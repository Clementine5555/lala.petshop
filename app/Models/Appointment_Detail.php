<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment_Detail extends Model
{
    // Migration creates `appointment_details` (plural) so make model match
    protected $table = 'appointment_details';
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

    // Tipe data casting untuk kolom tanggal 
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel user
     * satu appointment detail dimiliki satu user 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke table groomer 
     */
    public function groomer(): BelongsTo
    {
        return $this->belongsTo(Groomer::class, 'groomer_id', 'groomer_id');
    }

    /**
     * Relasi ke tabel pet
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    /**
     * Relasi ke tabel appointment
     * satu appointment detail memiliki banyak appointment (riwayat)
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'appointment_detail_id', 'appointment_detail_id');
    }
}
