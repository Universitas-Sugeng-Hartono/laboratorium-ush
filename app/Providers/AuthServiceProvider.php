<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('isSuper', function ($user) {
            return $user->role == 'super';
        });
        Gate::define('isICT', function ($user) {
            return $user->role == 'labict';
        });
        Gate::define('isMulti', function ($user) {
            return $user->role == 'labmultimedia';
        });
        Gate::define('isICT2', function ($user) {
            return $user->role == 'labict2';
        });
        Gate::define('isGizi', function ($user) {
            return $user->role == 'labgizi';
        });
        Gate::define('isTekpang', function ($user) {
            return $user->role == 'labtekpang';
        });
        Gate::define('isDosen', function ($user) {
            return $user->role == 'dosen';
        });
        Gate::define('isLab', function ($user) {
            return $user->role == 'laboran';
        });
    }
}