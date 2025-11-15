<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'transaction_detail_id';
    // protected $fillable = [
    //     'transaction_id',
    //     'product_id',
    //     'cart_id',
    //     'quantity',
    // ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function refundDetails(): HasMany
    {
        return $this->hasMany(RefundDetail::class, 'transaction_detail_id', 'transaction_detail_id');
    }
}