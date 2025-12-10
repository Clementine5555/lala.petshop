<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use HasFactory, SoftDeletes;

    // INI KUNCI UTAMANYA AGAR TIDAK ERROR ROLLBACK
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'user_id',
        'payment_id',
        'delivery_method',
        'status',
        'total_price',
        'receiver_name',
        'receiver_address',
        'receiver_phone',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class, 'transaction_id', 'transaction_id');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'transaction_id');
    }

    public function refundHeader(): HasOne
    {
        return $this->hasOne(RefundHeader::class, 'transaction_id', 'transaction_id');
    }
}
