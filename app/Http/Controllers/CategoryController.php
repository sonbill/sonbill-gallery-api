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
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Failed to add Category!'
            ], Response::HTTP_BAD_REQUEST);
        } else {
            // ADD CATEGORY
            $category = new Category;
            $category->name = $request->all();
            $category->save();
            return response()->json([
                'message' => 'Category added successfully!'
            ], Response::HTTP_OK);
        }
    }
}
