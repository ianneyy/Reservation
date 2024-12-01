<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariationSize extends Model
{
    use HasFactory;
    protected $fillable = ['product_variation_id', 'size', 'stock', 'created_at', 'updated_at'];

    // Define the inverse relationship with ProductVariation
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
