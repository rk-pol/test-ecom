<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductTypes;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'articul',
        'short_description',
        'long_description',
        'image_path',
        'price',
        'is_new',
        'brand_id',
        'animal_id',
        'product_type_id'
    ];

    public function prod_types()
    {
        return $this->hasOne(ProductTypes::class, 'id');
    }

    public function solds()
    {
        return $this->hasMany(ProductSold::class, 'product_id');
    }

    public function receives()
    {
        return $this->hasMany(ProductReceived::class, 'product_id');
    }
}
