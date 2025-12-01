<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'pet_id';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'race',
        'breed',
        'age',
        'weight',
        'gender',
        'description',
        'photo',
    ];

    protected $casts = [
        'age' => 'integer',
        'weight' => 'float',
    ];

    /**
     * Pet belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Pet has many Appointment Details
     */
    public function appointmentDetails(): HasMany
    {
        return $this->hasMany(Appointment_Detail::class, 'pet_id', 'pet_id');
    }
}
