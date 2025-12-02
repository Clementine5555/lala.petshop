<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'product_id',
        'user_id',
        'nama',
        'rating',      
        'comment',
        'date',
    ];

    public $timestamps = true;

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->date)) {
                $model->date = now();
            }
        });
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}