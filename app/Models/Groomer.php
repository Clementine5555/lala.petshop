<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groomer extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'groomer_id';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone_number',
        'address',
        'total_appointments_completed',
        'total_hours_worked',
    ];

    protected $casts = [
        'total_appointments_completed' => 'integer',
        'total_hours_worked' => 'integer',
    ];

    /**
     * Groomer belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Groomer has many Appointment Details
     */
    public function appointmentDetails(): HasMany
    {
        return $this->hasMany(Appointment_Detail::class, 'groomer_id', 'groomer_id');
    }

    /**
     * Groomer has many Appointments
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'groomer_id', 'groomer_id');
    }
}

