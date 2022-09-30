<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toy extends Model
{
    use HasFactory;

    protected $table = 'toies';

    protected $fillable = [
                            'type',
                            'demensions',
                            'material',
                            'age',
                            'product_id'
    ];
}
