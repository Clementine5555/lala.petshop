<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    // PERBAIKAN 1: Sesuaikan nama tabel dengan Migration (biasanya jamak)
    protected $table = 'appointments';

    protected $primaryKey = 'appointment_id';
    public $timestamps = true;

    // PERBAIKAN 2: Masukkan semua kolom baru ke sini agar bisa disimpan
    protected $fillable = [
        'groomer_id',
        'appointment_detail_id', // Jika masih pakai relasi ini
        'service_id',            // Jika masih pakai relasi ini
        'payment_id',            // Tambahan dari migration awal
        'appointment_date',      // Sesuaikan dengan nama di migration (bukan 'date')
        'status',

        // Kolom Detail Groomer yang baru kita tambah lewat Migration
        'customer_name',
        'pet_name',
        'pet_type',
        'pet_gender',
        'pet_weight',
        'service_type', // String manual (Full Grooming/Bath Only)
        'notes',
        'completed_at',
        'duration',
    ];

    protected $casts = [
        'appointment_date' => 'datetime', // Ubah 'date' jadi 'appointment_date'
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Helper: Menentukan Icon Hewan secara otomatis
     * Dipanggil di View dengan cara: $appointment->pet_icon
     */
    public function getPetIconAttribute()
    {
        // Cek apakah jenis hewan mengandung kata 'cat' atau 'kucing'
        if (stripos($this->pet_type, 'cat') !== false || stripos($this->pet_type, 'kucing') !== false) {
            return '🐱';
        }
        return '🐕'; // Default anjing
    }

    // --- RELASI (Biarkan saja jika memang dipakai di fitur lain) ---

    public function groomer(): BelongsTo
    {
        return $this->belongsTo(Groomer::class, 'groomer_id', 'groomer_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }

    public function appointmentDetail(): BelongsTo
    {
        return $this->belongsTo(Appointment_Detail::class, 'appointment_detail_id', 'appointment_detail_id');
    }
}
