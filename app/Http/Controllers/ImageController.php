<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return response()->json(
            [
                'images' => $images,
            ],
            Response::HTTP_OK
        );
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
            'title' => 'required',
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

    public function edit(int $image)
    {
        $subcategories = Subcategory::all();
        $image = Image::findOrFail($image);
        return compact('image', 'subcategories');
    }

    public function update(Request $request, $id)
    {
        $image = Image::find($id);
        $image->update($request->all());

        return response()->json(
            [
                'message' => 'Image updated successfully!',
            ],
            Response::HTTP_OK
        );
    }
    public function destroy(Image $image)
    {
        $image->delete();
        return response()->json(
            [
                'message' => 'Image deleted successfully!',
            ],
            Response::HTTP_OK
        );
    }
}
