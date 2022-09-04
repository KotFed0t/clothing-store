<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function showProducts()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return view('admin.products.index', compact('products'));
    }

    public function showProduct($productId)
    {
        $product = Product::findOrFail($productId);
        return view('admin.products.show', compact('product'));
    }

    public function showEditProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $categories = Category::get();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function editProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $params = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }

            $path = $request->file('image')->store('products');
            $params['image'] = $path;
        }

        $product->update($params);
        return redirect()->route('admin.products');
    }

    public function showCreateProduct()
    {
        $categories = Category::get();
        return view('admin.products.form', compact('categories'));
    }

    public function createProduct(Request $request)
    {
        $params = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products');
            $params['image'] = $path;
        }

        Product::create($params);
        return redirect()->route('admin.products');
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        if ($product->image) {
            Storage::delete($product->image);
        }

        Product::destroy($productId);
        return redirect()->route('admin.products');
    }
}
