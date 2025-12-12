<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentDetail extends Model
{
    use HasFactory, SoftDeletes;

    // Nama tabel di database
    protected $table = 'appointment_details';

    // Primary Key sesuai database kamu
    protected $primaryKey = 'appointment_detail_id';

    public $timestamps = true;

    protected $fillable = [
        'appointment_id',
        'service_id',
        'user_id',
        'groomer_id',
        'pet_id',
        'date',
        'time',
        'note',
        'status',
        'total_appointments_completed',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function groomer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'groomer_id', 'user_id');
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'appointment_detail_id', 'appointment_detail_id');
    }
}
