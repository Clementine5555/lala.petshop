<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'user_id',
        'payment_id',
        'delivery_method', // pickup, delivery
        'status', // pending, waiting_for_payment, Ready_for_pickup, completed, cancelled
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