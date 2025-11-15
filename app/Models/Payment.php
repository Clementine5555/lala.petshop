<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'payment_id';
    // protected $fillable = [
    //     'method',
    //     'status_payment',
    //     'evidence',
    // ];
    
    // Relasi One-to-One dengan Transaction
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'payment_id', 'payment_id');
    }

    // Relasi One-to-One dengan Appointment
    public function appointment(): HasOne
    {
        return $this->hasOne(Appointment::class, 'payment_id', 'payment_id');
    }
}