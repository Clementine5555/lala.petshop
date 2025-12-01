<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointment_id';
    public $timestamps = true;

    protected $fillable = [
        'groomer_id',
        'appointment_detail_id',
        'service_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Appointment belongs to Groomer
     */
    public function groomer(): BelongsTo
    {
        return $this->belongsTo(Groomer::class, 'groomer_id', 'groomer_id');
    }

    /**
     * Appointment belongs to Service
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    /**
     * Appointment belongs to Appointment Detail
     */
    public function appointmentDetail(): BelongsTo
    {
        return $this->belongsTo(Appointment_Detail::class, 'appointment_detail_id', 'appointment_detail_id');
    }
}
