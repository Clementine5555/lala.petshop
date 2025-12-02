<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category',
        'supplier_id',
    ];

    /**
     * Product belongs to a Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    /**
     * Product has many Reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    /**
     * Get average rating from reviews (0 if no reviews)
     */
    public function getAverageRatingAttribute()
    {
        $reviews = $this->reviews;
        if ($reviews->count() === 0) {
            return 0;
        }
        return round($reviews->avg('rating'), 1);
    }

    /**
     * Get review count
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews->count();
    }
}
