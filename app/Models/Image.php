<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'subcategory_id',
        'title',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
