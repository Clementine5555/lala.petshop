<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'courier_id';

    protected $fillable = [
        'user_id',
        'total_deliveries_completed',
        'total_distance_km',
    ];

    protected $casts = [
        'total_deliveries_completed' => 'integer',
        'total_distance_km' => 'float',
    ];

    /**
     * Courier belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Courier has many Deliveries
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'courier_id', 'courier_id');
    }
}
