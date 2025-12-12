<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';
    protected $primaryKey = 'delivery_id';

    // Agar bisa diisi massal
    protected $fillable = [
        'courier_id',
        'transaction_id',
        'address',
        'status', // enum: pending, shipped, delivered, returned
        'evidence',
        'description',
        'delivery_date'
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
    ];

    // Relasi ke Transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    // Relasi ke Courier (User)
    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id', 'user_id');
    }
}
