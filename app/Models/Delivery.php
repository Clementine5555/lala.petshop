<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'delivery_id';
    // protected $fillable = [
    //     'courier_id',
    //     'transaction_id',
    //     'address',
    //     'status', // pending, shipped, delivered, returned
    //     'description',
    //     'delivery_date',
    // ];

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class, 'courier_id', 'courier_id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }
}