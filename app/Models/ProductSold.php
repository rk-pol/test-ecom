<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSold extends Model
{
    use HasFactory;
    protected $table = 'products_solds';

    protected $fillable = [
        'value', 'product_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
