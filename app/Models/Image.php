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
        'category_id',
        'title',
        'roll',
        'date',
        'image',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
