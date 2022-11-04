<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\Mail\ResetPassword;
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

        $mailAuth = new MailAuthService();
        $mailAuth->sendRegistrationCode($data['email']);

        $qrCodeUrl = $ga->getQRCodeGoogleUrl('clothing-store', $secret);
        session([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'google_auth_secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl
        ]);

        return redirect()->route('registerShow2Fa');
    }

    public function showResetPasswordSend()
    {
        $captcha = new CaptchaService();
        $captchaImg = $captcha->generateCaptcha();
        return view('auth.resetPassword.sendForm', ['captchaImg' => $captchaImg]);
    }

    public function resetPasswordSend(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'string'],
            'captcha' => ['required']
        ]);

        if (session('captcha') !== $data['captcha']) {
            return redirect()->route('showResetPasswordSend')->withInput()->withErrors(['captcha' => 'Капча введена неверно']);
        }

        $user = User::where('email', $data['email'])->first();
        if ($user === null) {
            return redirect()->route('showResetPasswordSend')->withInput()->withErrors(['email' => 'Аккаунт с данным email не зарегистрирован']);
        }

        //сформировать ссылку и отправить на почту
        $token = bin2hex(random_bytes(32));
        $link = route('showResetPasswordSet') . '?'."email=$user->email"."&token=$token";
        $user->reset_password_token = $token;
        $user->token_expiration = time() + 3600;
        $user->save();
        Mail::to($user->email)->send(new ResetPassword($link));
        session()->flash('success', "Ссылка на страницу установки нового пароля, была отправлена на указанный Email ($user->email)");
        return redirect()->route('index');
    }

    public function showResetPasswordSet(Request $request)
    {
        if (!$request->has('email') || !$request->has('token')) {
            return redirect()->route('index');
        }
        $user = User::where('email', $request->get('email'))->first();

        if ($user === null) {
            session()->flash('warning', "Некорректные данные в запросе");
            return redirect()->route('index');
        }

        if ($user->reset_password_token !== $request->get('token')) {
            session()->flash('warning', "Некорректные данные в запросе");
            return redirect()->route('index');
        }

        if (time() > $user->token_expiration) {
            session()->flash('warning', "Время действия ссылки истекло");
            return redirect()->route('index');
        }

        session(['userId' => $user->id]);
        //показываем форму ввода пароля, после того как введет - запросить двухфакторку и уже после сохранить пароль и удалить токен из бд
        return view('auth.resetPassword.setForm');
    }

    public function resetPasswordSet(Request $request)
    {
        $data = $request->validate([
            'password' => [
                'required',
                'confirmed',
                'max:30',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ]);
        $user = User::findOrFail(session('userId'));
        $mailAuth = new MailAuthService();
        $mailAuth->setCodeAndSendToUser($user, 'resetPassword');
        session(['password' => bcrypt($data['password']), 'fromResetPassword' => true]);
        return redirect()->route('resetPasswordShow2Fa');

    }
}
