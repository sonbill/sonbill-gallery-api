<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }


    public function store(Request $request)
    {
        // VALIDATE
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:categories',
            'slug' => 'unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } else {
            // ADD CATEGORY
            Category::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
            ]);
            return response()->json([
                'message' => 'Category added successfully!'
            ], Response::HTTP_OK);
        }
    }

    //
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully!'
        ], Response::HTTP_OK);
    }
}
