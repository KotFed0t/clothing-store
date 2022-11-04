<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //здесь всегда первым параметром передается User. Аутентификацию проверять не нужно, а только роль или еще что-то.
        //неаутентифицированные пользователь проверку проходить не будет - gate сразу вернет false
        Gate::define('admin-manager-support', function (User $user) {
            if ($user->roles->contains('name', 'admin') || $user->roles->contains('name', 'manager') || $user->roles->contains('name', 'support')) return true;
            return false;
        });

        Gate::define('admin-manager', function (User $user) {
            if ($user->roles->contains('name', 'admin') || $user->roles->contains('name', 'manager')) return true;
            return false;
        });

        Gate::define('admin-support', function (User $user) {
            if ($user->roles->contains('name', 'admin') || $user->roles->contains('name', 'support')) return true;
            return false;
        });

        Gate::define('admin', function (User $user) {
            if ($user->roles->contains('name', 'admin')) return true;
            return false;
        });
    }
}
