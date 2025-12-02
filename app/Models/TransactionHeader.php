
<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class TransactionHeader extends Model
// {
//     protected $table = 'transaction_headers';
//     protected $primaryKey = 'transaction_header_id';
    
//     protected $fillable = [
//         'user_id',
//         'transaction_date',
//         'total_price',
//         'status',
//     ];

//     public function details()
//     {
//         return $this->hasMany(TransactionDetail::class, 'transaction_header_id', 'transaction_header_id');
//     }

//     public function user()
//     {
//         return $this->belongsTo(User::class);
//     }
// }