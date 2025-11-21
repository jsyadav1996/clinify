<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'clinic_location',
        'clinician_id',
        'appointment_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    /**
     * Get the clinician (user) that owns the appointment.
     */
    public function clinician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'clinician_id');
    }

    /**
     * Scope a query to only include appointments for a specific clinician.
     */
    public function scopeForClinician(Builder $query, int $clinicianId): Builder
    {
        return $query->where('clinician_id', $clinicianId);
    }

    /**
     * Scope a query to only include appointments with a specific status.
     */
    public function scopeWithStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include booked appointments.
     */
    public function scopeBooked(Builder $query): Builder
    {
        return $query->where('status', 'booked');
    }

    /**
     * Scope a query to only include completed appointments.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled appointments.
     */
    public function scopeCancelled(Builder $query): Builder
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query to only include upcoming appointments.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('appointment_date', '>=', now())
                    ->where('status', 'booked');
    }

    /**
     * Scope a query to only include upcoming appointments in the next N days.
     */
    public function scopeUpcomingDays(Builder $query, int $days = 7): Builder
    {
        return $query->where('appointment_date', '>=', now())
                    ->where('appointment_date', '<=', now()->addDays($days))
                    ->where('status', 'booked');
    }

    /**
     * Scope a query to only include past appointments.
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('appointment_date', '<', now());
    }

    /**
     * Scope a query to order appointments by date (ascending).
     */
    public function scopeOrderByDate(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('appointment_date', $direction);
    }
}
