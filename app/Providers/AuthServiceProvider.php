<?php

namespace App\Providers;

use App\Enums\Role;
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
        \App\Models\Product::class => \App\Policies\ProductPolicy::class,
        \App\Models\Appointment::class => \App\Policies\AppointmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define Gates for role-based authorization

        // Admin gate: Full access to everything
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        // Clinician gate: Limited access (only their own data)
        Gate::define('clinician', function ($user) {
            return $user->isClinician();
        });

        // Gate to check if user can access all data (admin only)
        Gate::define('access-all-data', function ($user) {
            return $user->canAccessAllData();
        });

        // Gate to check if user can only access their own data
        Gate::define('access-own-data', function ($user) {
            return $user->canOnlyAccessOwnData();
        });

        // Gate to check if user can manage resources (admin can manage all, clinician only their own)
        Gate::define('manage-resource', function ($user, $resource = null) {
            // Admin can manage everything
            if ($user->isAdmin()) {
                return true;
            }

            // Clinician can only manage their own resources
            if ($user->isClinician() && $resource) {
                // Check if the resource belongs to the user
                // This assumes resources have a user_id or created_by field
                if (isset($resource->user_id)) {
                    return $resource->user_id === $user->id;
                }
                if (isset($resource->created_by)) {
                    return $resource->created_by === $user->id;
                }
            }

            return false;
        });
    }
}
