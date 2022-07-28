<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'category_id', 'price', 'is_published'];
    protected $casts = [
        'is_published' => 'boolean',
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
