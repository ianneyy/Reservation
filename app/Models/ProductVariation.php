<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'variation_type', 'created_at', 'updated_at'];

    // Define the relationship between ProductVariation and ProductVariationSize
    public function sizes()
    {
        return $this->hasMany(ProductVariationSize::class);
    }

    // Define the inverse relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
