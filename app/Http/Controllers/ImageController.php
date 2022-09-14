<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'image_path' => 'required|image',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } else {
            // ADD IMAGE
            // $image = Str::random(32) . "." . $request->image_path->getClientOriginalExtension();

            $file = $request->hasFile('image_path');
            if ($file) {
                $newFile = $request->file('image_path');
                $file_path = $newFile->store('images');
                Image::create([
                    'subcategory_id' => $request->subcategory_id,
                    'title' => $request->title,
                    'size' =>   $request->file('image_path')->getSize(),
                    'image_path' => $file_path,
                    'slug' => Str::slug($request->title),
                ]);
            }

            // Image::create([
            //     'subcategory_id' => $request->subcategory_id,
            //     'title' => $request->title,
            //     'image_path' => $image,
            //     'slug' => Str::slug($request->title),
            // ]);

            // SAVE IMG IN STORAGE FOLDER
            // Storage::disk('public')->put($image, file_get_contents($request->image_path));

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
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'image_path' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => 'Validation Error.', $validator->errors(),
            ]);
        }

        $image = Image::find($id);
        if ($image) {
            $image->title = $input['title'];
            $image->slug = Str::slug($request->title);
            $image->image_path = $input['image_path'];
            $image->update();
            return response()->json([
                "success" => true,
                "message" => "Image updated successfully.",
                "data" => $image
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Image not found!",
            ]);
        }
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
