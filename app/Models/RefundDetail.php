<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundDetail extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'refund_detail_id';
    protected $fillable = [
        'refund_id',
        'transaction_detail_id',
        'quantity',
    ];

    public function refundHeader(): BelongsTo
    {
        return $this->belongsTo(RefundHeader::class, 'refund_id', 'refund_id');
    }

    public function transactionDetail(): BelongsTo
    {
        return $this->belongsTo(TransactionDetail::class, 'transaction_detail_id', 'transaction_detail_id');
    }
}