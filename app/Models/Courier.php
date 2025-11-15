<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'courier_id';
    protected $fillable = [
        'user_id',
        'total_deliveries_completed',
        'total_distance_km',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'courier_id', 'courier_id');
    }
}