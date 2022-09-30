<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderBrand extends Model
{
    use HasFactory;

    protected $table = 'providers_brands';
    
    protected $fillable = [
                    'provider_id', 
                    'brand_id',
                    'provider_brand'
    ];
}
