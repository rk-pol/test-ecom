<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalBrand extends Model
{
    use HasFactory;
    
    protected $table = 'animals_brands';

    public $timestamps = false;

    protected $fillable = [
                    'animal_id',
                    'brand_id',
                    'animal_brand'
    ];

}
