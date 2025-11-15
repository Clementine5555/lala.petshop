<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'product_id';
    protected $fillable = [
        'supplier_id',
        'name',
        'category',
        'description',
        'price',
        'stock',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }
    
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'product_id', 'product_id');
    }
}