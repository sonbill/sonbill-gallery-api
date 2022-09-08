<?php

namespace App\Http\Controllers;


use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class SubcategoryController extends Controller
{
    public function index()
    {
        $subCategories = Subcategory::all();
        return $subCategories;
    }
    public function store(Request $request)
    {
        // VALIDATE

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required',
            'place' => 'required',
            'city' => 'required',
            'roll' => 'required',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } else {
            //ADD SUB CATEGORY
            Subcategory::create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'place' => $request->place,
                'city' => $request->city,
                'roll' => $request->roll,
                'description' => $request->description,
                'slug' => Str::slug($request->title),
            ]);
            return response()->json(
                [
                    'message' => 'Sub-Category added successfully!'
                ],
                Response::HTTP_OK
            );
        }
    }
    // UPDATE
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'place' => 'required',
            'city' => 'required',
            'roll' => 'required',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                // "message" => 'Validation Error.', $validator->errors(),
                "message" => 'Fail',
            ]);
        }

        $subCategory = Subcategory::find($id);

        if ($subCategory) {
            $subCategory->title = $input['title'];
            $subCategory->place = $input['place'];
            $subCategory->city = $input['city'];
            $subCategory->roll = $input['roll'];
            $subCategory->description = $input['description'];
            $subCategory->slug = Str::slug($request->title);
            $subCategory->update();

            return response()->json([
                "success" => true,
                "message" => "Sub Category updated successfully.",
                "data" => $subCategory
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Category not found!",
            ], Response::HTTP_NOT_FOUND);
        }
    }
    // DELETE
    public function destroy($id)
    {
        $subCategory = Subcategory::find($id);
        $subCategory->delete();
        return response()->json([
            'message' => 'Sub Category deleted successfully!'
        ], Response::HTTP_OK);
    }
}
