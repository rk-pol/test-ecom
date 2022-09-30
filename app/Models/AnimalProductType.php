<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalProductType extends Model
{
    use HasFactory;

    protected $table = 'animals_product_types';

    protected $fillable = [
                            'animal_id',
                            'product_type_id', 
                            'image_path',
                            'animal_product_type'
    ];
}
