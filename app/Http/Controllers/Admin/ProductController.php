<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $properties = Property::get();
        return view('admin.products.form', compact('product', 'categories', 'properties'));
    }

    public function editProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $params = $request->all();
        $values = $request->get('values_id');
        //удаление и вставка свойств
        foreach ($values as $value) {
            $data[] = ['product_id' => $productId, 'value_id' => $value];
        }
        DB::table('product_value')->where('product_id', $productId)->delete();
        DB::table('product_value')->insert($data);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }

            $path = $request->file('image')->store('products');
            $params['image'] = $path;
        }

        if ($request->hasFile('images')) {

            Storage::delete($product->images());
            DB::table('image_product')->where('product_id', $product->id)->delete();

            foreach ($request->file('images') as $img) {
                $path = $img->store('products');
                DB::table('image_product')->insert(['product_id' => $product->id, 'image' => $path]);
            }
        }

        $product->update($params);
        return redirect()->route('admin.products');
    }

    public function showCreateProduct()
    {
        $categories = Category::get();
        $properties = Property::get();
        return view('admin.products.form', compact('categories', 'properties'));
    }

    public function createProduct(Request $request)
    {
        $params = $request->all();
        $values = $request->get('values_id');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products');
            $params['image'] = $path;
        }

        $productId = Product::create($params)->id;

        //сохранение дополнительных фото
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products');
                DB::table('image_product')->insert(['product_id' => $productId, 'image' => $path]);
            }
        }

        //удаление и вставка свойств
        foreach ($values as $value) {
            $data[] = ['product_id' => $productId, 'value_id' => $value];
        }
        DB::table('product_value')->where('product_id', $productId)->delete();
        DB::table('product_value')->insert($data);

        return redirect()->route('admin.products');
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        if ($product->image) {
            Storage::delete($product->image);
        }

        Storage::delete($product->images());
        DB::table('image_product')->where('product_id', $product->id)->delete();

        DB::table('product_value')->where('product_id', $productId)->delete();

        Product::destroy($productId);
        return redirect()->route('admin.products');
    }
}
