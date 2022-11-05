<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\Models\Order;
use App\Models\User;
use App\Services\GoogleAuth;
use App\Services\MailAuthService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TwoFaController extends Controller
{
    public function registerShow2Fa()
    {
        if(session('google_auth_secret') === null) {
            return redirect()->route('register');
        }
        return view('twoFa.register2Fa');
    }

    public function registerCheck2Fa(Request $request)
    {
        if(session('google_auth_secret') === null) {
            return redirect()->route('register');
        }

        $ga = new GoogleAuth();

        $data = $request->validate([
            'email_code' => ['required'],
            'googleAuthCode' => ['required']
        ]);

        if (time() > session('email_code_expiration')) {
            return redirect()->route('registerShow2Fa')->withInput()->withErrors(['email_code' => 'время жизни кода истекло']);
        }

        if ($data['email_code'] != session('email_code')) {
            return redirect()->route('registerShow2Fa')->withInput()->withErrors(['email_code' => 'введен неверный код']);
        }

        if (!$ga->verifyCode(session('google_auth_secret'), $data['googleAuthCode'])) {
            return redirect()->route('registerShow2Fa')->withInput()->withErrors(['googleAuthCode' => 'введен неверный код']);
        }

        $user = User::create([
            'name' => session('name'),
            'email' => session('email'),
            'password' => session('password'),
            'phone' => session('phone'),
            'google_auth_secret' => session('google_auth_secret')
        ]);

        session()->forget(['name', 'email', 'password', 'phone', 'google_auth_secret', 'email_code', 'email_code_expiration']);
        if ($user) {
            session()->flash('success', 'Регистрация прошла успешно. Войдите в свой аккаунт');
            return redirect()->route('login');
        }
        session()->flash('warning', 'Что-то пошло не так, попробуйте пройти регистрацию еще раз');
        return redirect()->route('register');
    }

    public function loginShow2Fa()
    {
        if(session('fromLogin') === null) {
            return redirect()->route('login');
        }

        return view('twoFa.2Fa', ['fromLogin' => true]);
    }

    public function loginCheck2Fa(Request $request)
    {
        if(session('fromLogin') === null) {
            return redirect()->route('login');
        }

        $ga = new GoogleAuth();

        $data = $request->validate([
            'email_code' => ['required'],
            'googleAuthCode' => ['required']
        ]);

        $userId = session('userId');
        $user = User::findOrFail($userId);


        if (time() > $user->email_code_expiration) {
            return redirect()->route('loginShow2Fa')->withInput()->withErrors(['email_code' => 'время жизни кода истекло']);
        }

        if ($data['email_code'] != $user->email_code) {
            return redirect()->route('loginShow2Fa')->withInput()->withErrors(['email_code' => 'введен неверный код']);
        }

        if (!$ga->verifyCode($user->google_auth_secret, $data['googleAuthCode'])) {
            return redirect()->route('loginShow2Fa')->withInput()->withErrors(['googleAuthCode' => 'введен неверный код']);
        }

        session()->forget(['userId', 'fromLogin', 'captcha']);
        Auth::loginUsingId($user->id);

        return redirect()->route('index');
    }

    public function orderShow2Fa()
    {
        if(session('fromOrder') === null) {
            return redirect()->route('index');
        }

        return view('twoFa.2Fa', ['fromOrder' => true]);
    }

    public function orderCheck2Fa(Request $request)
    {
        if(session('fromOrder') === null) {
            return redirect()->route('index');
        }

        $user = Auth::user();

        $ga = new GoogleAuth();

        $data = $request->validate([
            'email_code' => ['required'],
            'googleAuthCode' => ['required']
        ]);

        if (time() > $user->email_code_expiration) {
            return redirect()->route('orderShow2Fa')->withInput()->withErrors(['email_code' => 'время жизни кода истекло']);
        }

        if ($data['email_code'] != $user->email_code) {
            return redirect()->route('orderShow2Fa')->withInput()->withErrors(['email_code' => 'введен неверный код']);
        }

        if (!$ga->verifyCode($user->google_auth_secret, $data['googleAuthCode'])) {
            return redirect()->route('orderShow2Fa')->withInput()->withErrors(['googleAuthCode' => 'введен неверный код']);
        }

        $order = Order::find(session('orderId'));

        $payment = new PaymentService();
        $link = $payment->createPayment($order, $user->id);

        session()->forget(['orderId', 'fromOrder']);

        return redirect($link);
    }
    public function resetPasswordShow2Fa()
    {
        if(session('fromResetPassword') === null) {
            return redirect()->route('index');
        }

        return view('twoFa.2Fa', ['fromResetPassword' => true]);
    }

    public function resetPasswordCheck2Fa(Request $request)
    {
        if(session('fromResetPassword') === null) {
            return redirect()->route('index');
        }

        $ga = new GoogleAuth();

        $data = $request->validate([
            'email_code' => ['required'],
            'googleAuthCode' => ['required']
        ]);

        $userId = session('userId');
        $user = User::findOrFail($userId);


        if (time() > $user->email_code_expiration) {
            return redirect()->route('resetPasswordShow2Fa')->withInput()->withErrors(['email_code' => 'время жизни кода истекло']);
        }

        if ($data['email_code'] != $user->email_code) {
            return redirect()->route('resetPasswordShow2Fa')->withInput()->withErrors(['email_code' => 'введен неверный код']);
        }

        if (!$ga->verifyCode($user->google_auth_secret, $data['googleAuthCode'])) {
            return redirect()->route('resetPasswordShow2Fa')->withInput()->withErrors(['googleAuthCode' => 'введен неверный код']);
        }

        $user->password = session('password');
        $user->reset_password_token = null;
        $user->token_expiration = null;
        $user->save();

        session()->forget(['userId', 'fromResetPassword', 'password']);
        session()->flash('success', "Пароль успешно изменен!");
        return redirect()->route('login');
    }

}
