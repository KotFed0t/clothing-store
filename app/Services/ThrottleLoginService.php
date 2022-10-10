<?php

namespace App\Services;

use App\Models\LoginAttempts;

class ThrottleLoginService
{
    private $ip;
    private $login;

    public function __construct($ip, $login)
    {
        $this->ip = $ip;
        $this->login = $login;
    }

    public function hasTooManyLoginAttempts()
    {
        $loginAttempts = LoginAttempts::where('ip', $this->ip)->where('login', $this->login)->first();
        if ($loginAttempts === null) {
            LoginAttempts::create([
                'login' => $this->login,
                'ip' => $this->ip,
                'count' => 0
            ]);
            return false;
        }

        if ($loginAttempts->count === 5) {
            if ($loginAttempts->throttle_expiration < time()) {
                $this->resetCounter();
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function getThrottleExpiration()
    {
        $loginAttempts = LoginAttempts::where('ip', $this->ip)->where('login', $this->login)->first();
        return $loginAttempts->throttle_expiration - time();
    }

    public function updateCounter()
    {
        $loginAttempts = LoginAttempts::where('ip', $this->ip)->where('login', $this->login)->first();
        $loginAttempts->count = $loginAttempts->count + 1;
        if ($loginAttempts->count === 5) {
            $loginAttempts->throttle_expiration = time() + 60;
            session()->flash('warning', "Вы превысили допустимое количество попыток входа. Повторить попытку можно через: 60 сек.");
        }

        $loginAttempts->save();
    }

    public function resetCounter()
    {
        $loginAttempts = LoginAttempts::where('ip', $this->ip)->where('login', $this->login)->first();
        $loginAttempts->count = 0;
        $loginAttempts->throttle_expiration = null;
        $loginAttempts->save();
    }
}
