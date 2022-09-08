<?php

namespace App\Models;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'subcategory_id',
        'slug',
        'image_path',
        'title',
    ];

    public function subCategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
