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
            'title' => 'required|unique:subcategories',
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
    public function destroy($id)
    {
        $subCategory = Subcategory::find($id);
        $subCategory->delete();
        return response()->json([
            'message' => 'Sub Category deleted successfully!'
        ], Response::HTTP_OK);
    }
}
