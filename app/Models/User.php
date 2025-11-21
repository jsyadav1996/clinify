<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => Role::class,
    ];

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }

    /**
     * Check if the user is a clinician.
     */
    public function isClinician(): bool
    {
        return $this->role === Role::CLINICIAN;
    }

    /**
     * Check if the user can access all data (admin only).
     */
    public function canAccessAllData(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if the user can only access their own data.
     */
    public function canOnlyAccessOwnData(): bool
    {
        return $this->isClinician();
    }

    /**
     * Get the appointments for the user (as clinician).
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'clinician_id');
    }
}
