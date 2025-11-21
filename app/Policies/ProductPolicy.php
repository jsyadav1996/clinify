<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     * Admin can view all, Clinician can view their own.
     */
    public function viewAny(User $user): bool
    {
        return true; // Both admin and clinician can view products
    }

    /**
     * Determine whether the user can view the model.
     * Admin can view any, Clinician can only view their own.
     */
    public function view(User $user, Product $product): bool
    {
        // Admin can view any product
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only view their own products
        return $user->isClinician() && $product->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     * Both admin and clinician can create products.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Admin can update any, Clinician can only update their own.
     */
    public function update(User $user, Product $product): bool
    {
        // Admin can update any product
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only update their own products
        return $user->isClinician() && $product->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     * Admin can delete any, Clinician can only delete their own.
     */
    public function delete(User $user, Product $product): bool
    {
        // Admin can delete any product
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only delete their own products
        return $user->isClinician() && $product->user_id === $user->id;
    }
}
