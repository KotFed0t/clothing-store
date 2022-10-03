<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\Models\User;
use App\Services\GoogleAuth;
use App\Services\MailAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function showRegisterForm()
    {
        return view("auth.register");
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
            'password' => ['required']
        ]);

        if (auth()->attempt($data)) {
            if (auth()->user()->email_status !== 'verified') { // елси не верифицирован - то генерим снова google secret и отсылаем снова код на почту
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
                return redirect()->route('registerShow2Fa');
            }

            $user = auth()->user();
            $mailAuth = new MailAuthService();
            $mailAuth->setCodeAndSendToUser($user, 'login');

            session(['userId' => $user->id]);
            session(['fromLogin' => true]);

            auth()->logout();

            return redirect()->route('loginShow2Fa');
        }

        return redirect()->route('login')->withErrors(['email' => 'Неверные логин или пароль']);
    }

    public function register(Request $request)
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
            ]
        ]);

//        $token = Str::random(16);
//        $link = route('email_confirmation') . '?token=' . $token . '&email=' . $data['email'];

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

    public function emailConfirmation(Request $request)
    {
        $token = $request->get('token');
        $email = $request->get('email');
        $user = User::where('email_status','=', $token)->where('email', '=', $email)->first();
        if ($user) {
            $user->update(['email_status' => 'verified']);
            session()->flash('success', 'Почта успешно подтверждена!');
            return redirect()->route('index');
        }
        session()->flash('warning', 'Что-то пошло не так...');
        return redirect()->route('index');
    }
}
