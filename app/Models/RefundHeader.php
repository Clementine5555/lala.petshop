<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefundHeader extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'refund_id'; 
    protected $fillable = [
        'transaction_id',
        'date',
        'reason',
        'status_refund', // reviewing, approved, rejected, refunded
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(RefundDetail::class, 'refund_id', 'refund_id');
    }
}