<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bath extends Model
{
    use HasFactory;

    protected $table = 'bath';

    protected $fillable = [
                            'age',
                            'product_id'
    ];
}
