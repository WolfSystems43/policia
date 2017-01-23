<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('regenerate-frequencies', function ($user) {
            return $user->isMando() || $user->isAdmin();
        });


        Gate::define('view-secret-specialty', function ($user, $specialty) {

            // Si es Admin o Mando
            if($user->isAdmin() || $user->isMando()) {
                return true;
            }

            if(!$specialty->secret) {
                return true;
            }

            if($user->specialties->where('id', $specialty->id)->count() > 0) {
                return true;
            }

            return false;
        });

        Gate::define('view-specialty-message', function($user, $specialty) {
            // Si es Admin o Mando
            if($user->isAdmin() || $user->isMando()) {
                return true;
            }
            
            if($user->specialties->where('id', $specialty->id)->count() > 0) {
                return true;
            }

            return false;

        });

    }
}
