<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'transaction_id',
        'user_id',
        'method',
        'status',
        'evidence',
    ];

    protected $casts = [
        'method' => 'string',
        'status' => 'string',
        'evidence' => 'string',
    ];

    /**
     * Payment belongs to Transaction
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    /**
     * Payment belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Optional: one-to-one with Appointment (if payments used for appointments)
     */
    public function appointment(): HasOne
    {
        return $this->hasOne(Appointment::class, 'payment_id', 'payment_id');
    }
}
