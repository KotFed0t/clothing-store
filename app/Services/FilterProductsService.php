<?php

namespace App\Services;

use App\Models\Product;

class FilterProductsService
{
    public static function filter($request, $gender, $category_id = null)
    {
        $properties = [];

        if ($request->filled('sort') && $request->get('sort') != 0) {
            switch ($request->get('sort')) {
                case 'price_asc':
                    $column = 'price';
                    $direction = 'asc';
                    break;
                case 'price_desc':
                    $column = 'price';
                    $direction = 'desc';
                    break;
                case 'name_asc':
                    $column = 'name';
                    $direction = 'asc';
                    break;
                case 'name_desc':
                    $column = 'name';
                    $direction = 'desc';
                    break;
            }
        }

        if (isset($column) && isset($direction)) {
            if (isset($category_id)) {
                $products = Product::where('category_id', $category_id)->where('gender', $gender)->orderBy($column, $direction)->get();
            } else {
                $products = Product::where('gender', $gender)->orderBy($column, $direction)->get();
            }
        } else {
            if (isset($category_id)) {
                $products = Product::where('category_id', $category_id)->where('gender', $gender)->get();
            } else {
                $products = Product::where('gender', $gender)->get();
            }
        }


        if ($request->filled('цвет_id')) {
            $properties['color'] = $request->get('цвет_id');
        }

        if ($request->filled('материал_id')) {
            $properties['material'] = $request->get('материал_id');
        }

        if ($request->filled('бренд_id')) {
            $properties['brand'] = $request->get('бренд_id');
        }

        if ($request->filled('размер_id')) {
            $properties['size'] = $request->get('размер_id');
        }

        $countProperties = count($properties);

        $products = $products->filter(function ($product) use ($properties, $countProperties) {
            $matchedProperties = 0;
            foreach ($properties as $property) { // итерация по properties цвету, бренду и т.д
                foreach ($property as $value) { // итерация по значениям properties (value_id) кожа, мех и т.д
                    if ($product->values->contains('id', $value)) {
                        $matchedProperties++;
                        break;
                    }
                }
            }
            return $matchedProperties == $countProperties; // по каждому свойству есть хотябы одно совпадение?
        })->paginate(3)->withPath('?' . $request->getQueryString());

        return $products;
    }

}
