<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;


   protected $fillable = [ 'name', 'description', 'price', 'category', 'subcategory', 'available', 'image', ];


    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];
}