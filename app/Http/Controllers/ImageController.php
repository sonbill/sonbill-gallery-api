<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return $images;
    }

    public function create()
    {
        $subcategories = Subcategory::all();
        return $subcategories;
    }

    public function store(Request $request)
    {
        Image::create([
            'subcategory_id' => $request->subcategory_id,
            'title' => $request->title,
        ]);
        return response()->json(
            [
                'message' => 'Images added successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
