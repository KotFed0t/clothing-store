<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmation;
use App\Models\User;
use App\Services\GoogleAuth;
use App\Services\MailAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TwoFaController extends Controller
{
    public function registerShow2Fa()
    {
        if(session('secret') === null) {
            return redirect()->route('register');
        }
        return view('twoFa.register2Fa');
    }

    public function registerCheck2Fa(Request $request)
    {
        if(session('secret') === null) {
            return redirect()->route('register');
        }

        $ga = new GoogleAuth();

        $data = $request->validate([
            'email_code' => ['numeric'],
            'googleAuthCode' => ['numeric']
        ]);

        $userId = session('userId');
        $user = User::findOrFail($userId);


        if (time() > $user->email_code_expiration) {
            return redirect()->route('registerShow2Fa')->withErrors(['email_code' => 'время жизни кода истекло']);
        }

        if ($data['email_code'] != $user->email_code) {
            return redirect()->route('registerShow2Fa')->withErrors(['email_code' => 'введен неверный код']);
        }

        if (!$ga->verifyCode($user->google_auth_secret, $data['googleAuthCode'])) {
            return redirect()->route('registerShow2Fa')->withErrors(['googleAuthCode' => 'введен неверный код']);
        }

        $user->email_status = 'verified';
        $user->save();

        session()->forget(['userId', 'secret', 'qrCodeUrl']);

        return redirect()->route('login');
    }

    public function loginShow2Fa()
    {
        if(session('fromLogin') === null) {
            return redirect()->route('login');
        }

        return view('twoFa.login2Fa');
    }

    public function loginCheck2Fa(Request $request)
    {
        if(session('fromLogin') === null) {
            return redirect()->route('login');
        }

        $ga = new GoogleAuth();

        $data = $request->validate([
            'email_code' => ['numeric'],
            'googleAuthCode' => ['numeric']
        ]);

        $userId = session('userId');
        $user = User::findOrFail($userId);


        if (time() > $user->email_code_expiration) {
            return redirect()->route('loginShow2Fa')->withErrors(['email_code' => 'время жизни кода истекло']);
        }

        if ($data['email_code'] != $user->email_code) {
            return redirect()->route('loginShow2Fa')->withErrors(['email_code' => 'введен неверный код']);
        }

        if (!$ga->verifyCode($user->google_auth_secret, $data['googleAuthCode'])) {
            return redirect()->route('loginShow2Fa')->withErrors(['googleAuthCode' => 'введен неверный код']);
        }

        session()->forget(['userId', 'fromLogin']);
        Auth::loginUsingId($user->id);

        return redirect()->route('index');
    }


}
