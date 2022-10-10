<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\Models\User;
use App\Services\CaptchaService;
use App\Services\GoogleAuth;
use App\Services\MailAuthService;
use App\Services\ThrottleLoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $captcha = new CaptchaService();
        $captchaImg = $captcha->generateCaptcha();
        return view('auth.login', ['captchaImg' => $captchaImg]);
    }

    public function showRegisterForm()
    {
        $captcha = new CaptchaService();
        $captchaImg = $captcha->generateCaptcha();
        return view("auth.register", ['captchaImg' => $captchaImg]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }

    public function login_process(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'string'],
            'password' => ['required'],
            'captcha' => ['required']
        ]);

        $ip = $request->ip();
        $tls = new ThrottleLoginService($ip, $data['email']);

        if ($tls->hasTooManyLoginAttempts()) {
            $remains = $tls->getThrottleExpiration();
            session()->flash('warning', "Вы превысили допустимое количество попыток входа. Повторить попытку можно через: $remains сек.");
            return redirect()->route('login')->withInput()->withErrors(['email' => 'Неверные логин или пароль']);
        }

        if (session('captcha') !== $data['captcha']) {
            $tls->updateCounter();
            return redirect()->route('login')->withInput()->withErrors(['captcha' => 'Капча введена неверно']);
        }

        if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            if (auth()->user()->email_status !== 'verified') { // если не верифицирован - то генерим снова google secret и отсылаем снова код на почту
                $user = auth()->user();
                $mailAuth = new MailAuthService();
                $mailAuth->setCodeAndSendToUser($user, 'register');

                $ga = new GoogleAuth();
                $secret = $ga->createSecret();
                $user->google_auth_secret = $secret;
                $user->save();

                $qrCodeUrl = $ga->getQRCodeGoogleUrl('clothing-store', $secret);
                session(['userId' => $user->id]);
                session(['secret' => $secret]);
                session(['qrCodeUrl' => $qrCodeUrl]);

                auth()->logout();
                $tls->resetCounter();
                return redirect()->route('registerShow2Fa');
            }

            $user = auth()->user();
            $mailAuth = new MailAuthService();
            $mailAuth->setCodeAndSendToUser($user, 'login');

            session(['userId' => $user->id]);
            session(['fromLogin' => true]);

            auth()->logout();
            $tls->resetCounter();
            return redirect()->route('loginShow2Fa');
        }

        $tls->updateCounter();
        return redirect()->route('login')->withInput()->withErrors(['email' => 'Неверные логин или пароль']);

    }

    public function register_process(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'email' => ['required', 'email', 'string', 'unique:users'],
            'phone' => ['required', 'regex:/(\+7|8)[\s(]*\d{3}[)\s]*\d{3}[\s-]?\d{2}[\s-]?\d{2}/'],
            'password' => [
                'required',
                'confirmed',
                'max:30',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'captcha' => ['required']
        ]);

        if (session('captcha') !== $data['captcha']) {
            return redirect()->route('register')->withInput()->withErrors(['captcha' => 'Капча введена неверно']);
        }

        $ga = new GoogleAuth();
        $secret = $ga->createSecret();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'google_auth_secret' => $secret
        ]);

        if ($user) {
            $mailAuth = new MailAuthService();
            $mailAuth->setCodeAndSendToUser($user, 'register');

            $qrCodeUrl = $ga->getQRCodeGoogleUrl('clothing-store', $secret);
            session(['userId' => $user->id]);
            session(['secret' => $secret]);
            session(['qrCodeUrl' => $qrCodeUrl]);
        }

        return redirect()->route('registerShow2Fa');
    }
}
