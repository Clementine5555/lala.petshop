<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'pet_id';
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'race',
        'gender',
        'age',
        'weight',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function appointmentDetails(): HasMany
    {
        return $this->hasMany(AppointmentDetail::class, 'pet_id', 'pet_id');
    }
}