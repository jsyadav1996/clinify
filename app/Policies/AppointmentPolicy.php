<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     * Admin can view all, Clinician can view their own.
     */
    public function viewAny(User $user): bool
    {
        return true; // Both admin and clinician can view appointments
    }

    /**
     * Determine whether the user can view the model.
     * Admin can view any, Clinician can only view their own.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        // Admin can view any appointment
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only view their own appointments
        return $user->isClinician() && $appointment->clinician_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     * Both admin and clinician can create appointments.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Admin can update any, Clinician can only update their own.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        // Admin can update any appointment
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only update their own appointments
        return $user->isClinician() && $appointment->clinician_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     * Admin can delete any, Clinician can only delete their own.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        // Admin can delete any appointment
        if ($user->isAdmin()) {
            return true;
        }

        // Clinician can only delete their own appointments
        return $user->isClinician() && $appointment->clinician_id === $user->id;
    }
}
