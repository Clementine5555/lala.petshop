<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\AppointmentDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groomer extends Model
{
    use HasFactory, SoftDeletes;

    // Menentukan Primary Key
    protected $primaryKey = 'groomer_id';

    // Mengizinkan mass assignment
    protected $fillable = [
        'user_id',
        'total_appointments_completed',
        'total_minutes_worked', 
    ];

    /**
     * Relasi: Groomer dimiliki oleh satu User (FK user_id).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Groomer memiliki banyak AppointmentDetails
     */
    public function appointmentDetails(): HasMany
    {
        return $this->hasMany(AppointmentDetail::class, 'groomer_id', 'groomer_id');
    }
}