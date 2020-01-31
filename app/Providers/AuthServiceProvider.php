<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->role_id === 1;
        });
        Gate::define('isApprover', function ($user) {
            return $user->role_id === 2;
        });
        Gate::define('isUser', function ($user) {
            return $user->role_id === 3;
        });
        Gate::define('isMyaccount', function ($user, $profileUser) {
            return $user->id === $profileUser->id;
        });

        Passport::routes();
        //
    }
}
