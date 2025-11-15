<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'appointment_id';
    protected $fillable = [
        'payment_id',
        'status', // pending, confirmed, completed, cancelled
    ];
    
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }

    public function AppointmentDetails(): HasMany
    {
        return $this->hasMany(AppointmentDetail::class, 'appointment_id', 'appointment_id');
    }
}