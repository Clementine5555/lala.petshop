<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'service_id';
    // protected $fillable = [
    //     'service_name',
    //     'description',
    //     'price',
    //     'duration_minutes',
    // ];
    
    public function appointmentDetails(): HasMany
    {
        return $this->hasMany(AppointmentDetail::class, 'service_id', 'service_id');
    }
}