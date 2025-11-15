<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'cart_id';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'status', // active, converted
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function transactionDetails(): HasMany
    {
        // Hubungan ini menghubungkan Cart dengan TransactionDetail yang menggunakan cart_id ini
        return $this->hasMany(TransactionDetail::class, 'cart_id', 'cart_id');
    }
}