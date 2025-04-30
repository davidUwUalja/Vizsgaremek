<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['name_hu','name_en', 'material_hu', 'material_en', 'description_hu', 'description_en', 'price_hu', 'price_en','image_url', 'stock', 'category_hu','category_en'];
}