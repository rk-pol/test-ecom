<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category', 'img_path'
    ];
    public function animal() 
    {
        return $this->hasMany(Animal::class, 'category_id', 'category_id');
    }
}
