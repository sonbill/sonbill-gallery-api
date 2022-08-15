<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Validator;
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
        // $subcategories = Subcategory::all();
        // return $subcategories;
    }

    public function store(Request $request)
    {
        // CHECK VALIDATE IMAGE
        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required',
            'title' => 'required|unique:images',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } else {
            // ADD IMAGE
            Image::create([
                'subcategory_id' => $request->subcategory_id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),

            ]);
            return response()->json(
                [
                    'message' => 'Images added successfully!'
                ],
                Response::HTTP_OK
            );
        }
    }
}
