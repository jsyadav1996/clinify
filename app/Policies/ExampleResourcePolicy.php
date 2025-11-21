<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Example Resource Policy
 * 
 * This is an example policy demonstrating how to use Policies for resource authorization.
 * You can create similar policies for your resources (e.g., AppointmentPolicy, ProductPolicy).
 * 
 * Rules:
 * - Admin: Can perform all actions on all resources
 * - Clinician: Can only perform actions on their own resources
 */
class ExampleResourcePolicy
{
    /**
     * Determine whether the user can view any models.
     * Admin can view all, Clinician can only view their own.
     */
    public function viewAny(User $user): bool
    {
        // Admin can view all resources
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can view resources (but filtered to their own in the controller)
        return $user->isClinician();
    }

    /**
     * Determine whether the user can view the model.
     * Admin can view any, Clinician can only view their own.
     */
    public function view(User $user, User $model): bool
    {
        // Admin can view any resource
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only view their own resources
        return $user->isClinician() && $model->id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     * Both Admin and Clinician can create resources.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isClinician();
    }

    /**
     * Determine whether the user can update the model.
     * Admin can update any, Clinician can only update their own.
     */
    public function update(User $user, User $model): bool
    {
        // Admin can update any resource
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only update their own resources
        return $user->isClinician() && $model->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     * Admin can delete any, Clinician can only delete their own.
     */
    public function delete(User $user, User $model): bool
    {
        // Admin can delete any resource
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only delete their own resources
        return $user->isClinician() && $model->id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     * Only Admin can restore resources.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Only Admin can permanently delete resources.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}
