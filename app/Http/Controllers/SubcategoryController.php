<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class SubcategoryController extends Controller
{
    public function store(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        $category->subCategories()->create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ]);
        return response()->json(
            [
                'message' => 'SubCategory added successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
