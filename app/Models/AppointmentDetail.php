<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'appointment_detail_id';
    protected $fillable = [
        'appointment_id',
        'groomer_id',
        'service_id',
        'pet_id',
        'date',
        'time',
        'note',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'appointment_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
    
    public function groomer(): BelongsTo
    {
        return $this->belongsTo(Groomer::class, 'groomer_id', 'groomer_id');
    }
    
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }
}