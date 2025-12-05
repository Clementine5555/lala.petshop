<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Refund extends Model
{
    protected $table = 'refund';
    protected $primaryKey = 'refund_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'transaction_id',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Refund belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Refund belongs to Transaction
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    /**
     * Refund has many Refund Details
     */
    public function refundDetails(): HasMany
    {
        return $this->hasMany(RefundDetail::class, 'refund_id', 'refund_id');
    }
}
