<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Subcategory;
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
        $subcategory = Subcategory::findOrFail($request->subcategory_id);
        $subcategory->images()->create([
            'title' => $request->title,
        ]);
        return response()->json(
            [
                'message' => 'Image added successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
