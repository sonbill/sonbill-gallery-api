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
    // UPDATE CATEGORY
    public function update(Request $request, $id)
    {
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => 'Validation Error.', $validator->errors(),
            ]);
        }

        $category = Category::find($id);
        if ($category) {
            $category->title = $input['title'];
            $category->slug = Str::slug($request->title);
            $category->update();
            return response()->json([
                "success" => true,
                "message" => "Category updated successfully.",
                "data" => $category
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Category not found!",
            ]);
        }
    }

    //DELETE CATEGORY
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully!'
        ], Response::HTTP_OK);
    }
}
