<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'service_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    /**
     * Service has many AppointmentDetails
     */
    public function appointmentDetails(): HasMany
    {
        return $this->hasMany(Appointment_Detail::class, 'service_id', 'service_id');
    }
}
