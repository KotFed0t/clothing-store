<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function showCategories()
    {
       $categories = Category::get();
       return view('admin.categories.index', compact('categories'));
    }

    public function showCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.show', compact('category'));
    }

    public function showEditCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.categories.form', compact('category'));
    }

    public function editCategory(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $params = $request->all();

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::delete($category->image);
            }

            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }

        $category->update($params);
        return redirect()->route('admin.categories');
    }

    public function showCreateCategory()
    {
        return view('admin.categories.form');
    }

    public function createCategory(Request $request)
    {
        $params = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories');
            $params['image'] = $path;
        }

        Category::create($params);
        return redirect()->route('admin.categories');
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        if ($category->image) {
            Storage::delete($category->image);
        }

        Category::destroy($categoryId);
        return redirect()->route('admin.categories');
    }
}
