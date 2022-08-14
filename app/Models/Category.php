<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'title',
        'slug',
    ];

    public function subCategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
