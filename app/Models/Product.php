<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'product_id',
        'name',
        'image_product1',
        'image_product2',
        'description',
        'price_main',
        'price_sale',
    ];
}