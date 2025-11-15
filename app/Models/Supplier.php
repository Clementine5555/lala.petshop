<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends BaseModel
{
    use HasFactory, SoftDeletes;
    
    protected $primaryKey = 'supplier_id';
    // protected $fillable = [
    //     'name',
    //     'address',
    //     'email',
    //     'phone_number',
    // ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplier_id', 'supplier_id');
    }
}