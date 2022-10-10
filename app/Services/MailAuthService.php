<?php

namespace App\Services;

use App\Mail\EmailAuthLogin;
use App\Mail\EmailAuthOrder;
use App\Mail\EmailConfirmation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailAuthService
{
    public function generateCode()
    {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= rand(0, 9);
        }
        return $code;
    }

    public function setCodeAndSendToUser(User $user, $action, $order = null)
    {
        $code = $this->generateCode();

        $user->email_code = $code;
        $user->email_code_expiration = time() + 300;
        $user->save();

        switch ($action) {
            case 'register':
                Mail::to($user->email)->send(new EmailConfirmation($code));
                break;
            case 'login':
                Mail::to($user->email)->send(new EmailAuthLogin($code));
                break;
            case 'order':
                Mail::to($user->email)->send(new EmailAuthOrder($code, $order));
                break;
        }
    }
}
