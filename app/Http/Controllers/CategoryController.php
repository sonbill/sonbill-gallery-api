<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;



class CategoryController extends Controller
{
    public function create()
    {
    }


    public function store(Request $request)
    {
        // VALIDATE
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:category',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } else {
            // ADD CATEGORY
            $category = new Category;
            $category->title = $request->input('title');
            $category->parent_id = $request->input('parent_id');
            $category->save();
            return response()->json([
                'message' => 'Category added successfully!'
            ], Response::HTTP_OK);
        }
    }
}
