<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ==========================
    // Customer Relationships
    // ==========================

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id', 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id', 'user_id');
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class, 'user_id', 'user_id');
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class, 'user_id', 'user_id');
    }

    public function appointmentDetails(): HasMany
    {
        return $this->hasMany(Appointment_Detail::class, 'user_id', 'user_id');
    }

    // ==========================
    // Staff Relationships
    // ==========================

    public function groomer(): HasOne
    {
        return $this->hasOne(Groomer::class, 'user_id', 'user_id');
    }

    public function courier(): HasOne
    {
        return $this->hasOne(Courier::class, 'user_id', 'user_id');
    }
}
