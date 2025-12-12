<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $primaryKey = 'appointment_id';
    public $timestamps = true;

    // Sesuai dengan screenshot database kamu (image_4587fc.png)
    protected $fillable = [
        'payment_id',      // Ada di DB
        'status',          // Ada di DB
        'customer_name',   // Ada di DB
        'pet_name',        // Ada di DB
        'pet_type',        // Ada di DB
        'pet_gender',      // Ada di DB
        'pet_weight',      // Ada di DB
        'service_type',    // Ada di DB
        'notes',           // Ada di DB
        'completed_at',    // Ada di DB
        'duration',        // Ada di DB

        // HAPUS kolom yang TIDAK ADA di tabel appointments:
        // 'groomer_id',
        // 'appointment_detail_id',
        // 'service_id',
        // 'appointment_date',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // Helper icon
    public function getPetIconAttribute()
    {
        if (stripos($this->pet_type, 'cat') !== false || stripos($this->pet_type, 'kucing') !== false) {
            return '🐱';
        }
        return '🐕';
    }

    // --- RELASI ---

    // Ambil detail teknis (tanggal/jam) lewat relasi ini
    public function detail(): HasOne
    {
        return $this->hasOne(AppointmentDetail::class, 'appointment_id', 'appointment_id');
    }

    // Ambil Groomer lewat detail
    public function groomer()
    {
        return $this->hasOneThrough(
            User::class,
            AppointmentDetail::class,
            'appointment_id',
            'user_id',
            'appointment_id',
            'groomer_id'
        );
    }
}
