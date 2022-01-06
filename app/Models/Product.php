<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $date = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'price',
        'product_image_original_name',
        'product_image_original_url',
        'product_image_large_name',
        'product_image_large_url',
        'product_image_medium_name',
        'product_image_medium_url',
        'product_image_small_name',
        'product_image_small_url',
    ];

    public function productTransaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
