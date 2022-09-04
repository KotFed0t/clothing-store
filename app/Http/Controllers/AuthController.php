<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\Models\User;
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
            if (auth()->user()->email_status !== 'verified') {
                auth()->logout();
                return redirect()->route('login')->withErrors(['email' => 'Необходимо подтвердить почту, перейдя по ссылке в письме!']);
            }
            return redirect()->route('index');
        }

        return redirect()->route('login')->withErrors(['email' => 'Неверные логин или пароль']);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'email' => ['required', 'email', 'string'],
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

        $token = Str::random(16);
        $link = route('email_confirmation') . '?token=' . $token . '&email=' . $data['email'];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_status' => $token
        ]);

        if ($user) {
            Mail::to($data['email'])->send(new EmailConfirmation($link));
            session()->flash('success',
                'Для завершения регистрации перейдите по ссылке, отправленной вам на email и подтвердите адрес электронной почты');
        }

        return redirect()->route('index');
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
