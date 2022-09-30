<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $table = 'feed';
    
    protected $fillable = [
                            'type',
                            'taste',
                            'weight',
                            'age',
                            'product_id'
    ];

    public function products()
    {
        return $this->hasOne(Products::class, 'product_type_id');
    }
}
