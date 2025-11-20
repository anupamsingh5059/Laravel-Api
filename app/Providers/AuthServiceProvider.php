<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    \App\Models\Product::class => \App\Policies\ProductPolicy::class,
];

    public function boot(): void
    {
        $this->registerPolicies();

        // Gate for Admin only
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate for Employee only
        Gate::define('is-employee', function (User $user) {
            return $user->role === 'employee';
        });

        // Gate: Admin OR Employee both
        Gate::define('is-staff', function (User $user) {
            return in_array($user->role, ['admin', 'employee']);
        });
    }
}
