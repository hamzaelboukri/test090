<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'des' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $category = Category::create($validator->validated());
        return response()->json([
            'success' => true,
            'message' => 'category storet',
            'data' => $category
        ], 201);
    }

public function updet(Request $request ,$id){

    $categories= Category::findorfails($id) ;

    if($categories->fails()){
        return response()->json([
            'succes'=>false,
            'message'=>'id not fonds',
            'errors' => $categories->errors()
        ], 422);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|unique:categories',
        'des' => 'nullable|string',
    ]);

    if($validator->fails()){
        return response()->json([
            'succes'=>false,
            'message'=>'validation errors',
            'errors'=>$validator->errors()
        ],422);
    }

    $category = Category::create($validator->validated());
    return response()->json([
        'success' => true,
        'message' => 'category update',
        'data' => $category
    ], 201);
}




    

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category NOT fonds'
            ], 404);
        }

        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'category DELETE'
        ]);
    }

}