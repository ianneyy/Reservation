<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'created_at', 'updated_at'];

    // Define the relationship between Product and ProductVariation
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
