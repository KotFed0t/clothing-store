<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

    public function logout () {
        auth()->logout();
        return redirect()->route('index');
    }

    public function login_process (Request $request) {
        $data = $request->validate([
            'email' => ['required', 'email', 'string'],
            'password' => ['required']
        ]);

        if (auth()->attempt($data)) {
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

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        if ($user) {
            auth()->login($user);
        }

        return redirect()->route('index');
    }
}
