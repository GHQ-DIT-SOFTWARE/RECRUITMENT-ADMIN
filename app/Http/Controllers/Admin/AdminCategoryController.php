<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Auth;

class AdminCategoryController extends Controller
{
    //
    public function category()
    {
        return view('admin_academics.category.category');
    }

    public function getCategory()
    {
        $category = CategoryModel::orderBy('created_at', 'desc')->get();
        return response()->json($category);
    }

    public function getCategoryById($id)
    {
        $category = CategoryModel::find($id); // Correct model
        if ($category) {
            return response()->json($category);
        }
        return response()->json(['error' => 'Category not found'], 404);
    }

    public function category_add(Request $request)
    {
        $userID = Auth::id();
        $category = new CategoryModel();

        $category->user_id = $userID;
        $category->category_id = $request->input('category_id');
        $category->category_name = $request->input('category_name');
        $category->credit_hours = $request->input('credit_hours');
        $category->level = $request->input('level');
        $category->category_remarks = $request->input('category_remarks');
        $category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $category = CategoryModel::findOrFail($id);

        // Handle JSON and form data
        $inputData = $request->all();

        // Check if JSON data exists
        if ($request->isJson()) {
            $inputData = $request->json()->all();
        }

        // Validate input
        $allowedFields = ['category_id', 'category_name', 'credit_hours', 'level', 'category_remarks'];
        foreach ($inputData as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $category->$key = $value;
            }
        }

        $category->save();

        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }


    public function destroy($id)
    {
        $category = CategoryModel::find($id);

        if ($category) {
            $category->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Category not found'], 404);
    }
}
