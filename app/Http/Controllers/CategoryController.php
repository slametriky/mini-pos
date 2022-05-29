<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }
    
    public function data()
    {
        $categories = Category::with('product')->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories',            
        ]);  
   
        $category = Category::create($request->only('name'));
   
        return response()->json($category, 200);
    }

    public function update(Request $request, Category $category)
    {   
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,'.$category->id,            
        ]);  

        $category->fill($request->only('name'))->save();
   
        return response()->json($category, 200);
    }

    public function destroy(Category $category)
    {   
        $delete = $category->delete();

        return response()->json(['message' => 'success']);
    }
}
