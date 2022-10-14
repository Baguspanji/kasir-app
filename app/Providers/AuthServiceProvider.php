<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

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

        Gate::define('is_admin', fn(User $user) => $this->roles($user->role, ['admin']));
        Gate::define('is_employee', fn(User $user) => $this->roles($user->role, ['admin', 'employee']));
    }

    private function roles($role, $roles)
    {
        $inRole = false;
        if (in_array($role, $roles)) {
            $inRole = true;
        }

        return $inRole;
    }
}
