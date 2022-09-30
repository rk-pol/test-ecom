<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReceived extends Model
{
    use HasFactory;
    
    protected $table = 'products_receiveds';

    protected $fillable = [
        'value', 'product_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}
