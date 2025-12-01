<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund_Detail extends Model
{
    protected $table = 'refund_detail';
    protected $primaryKey = 'refund_detail_id';
    public $timestamps = true;

    protected $fillable = [
        'refund_id',
        'transaction_detail_id',
        'quantity',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Refund Detail belongs to Refund
     */
    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class, 'refund_id', 'refund_id');
    }

    /**
     * Refund Detail belongs to Transaction Detail
     */
    public function transactionDetail(): BelongsTo
    {
        return $this->belongsTo(Transaction_Detail::class, 'transaction_detail_id', 'transaction_detail_id');
    }
}
