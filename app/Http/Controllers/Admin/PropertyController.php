<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Property;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function showProperties()
    {
        $properties = Property::get();
        return view('admin.properties.index', compact('properties'));
    }

    public function showEditProperty($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        return view('admin.properties.form', compact('property'));
    }

    public function editProperty(Request $request, $propertyId)
    {
        $property = Property::findOrFail($propertyId);

        $property->name = $request->get('name');
        $property->save();
        return redirect()->route('admin.properties');
    }

    public function showCreateProperty()
    {
        return view('admin.properties.form');
    }

    public function createProperty(Request $request)
    {
        Property::create(['name' => $request->get('name')]);
        return redirect()->route('admin.properties');
    }

    public function deleteProperty($propertyId)
    {
        Property::destroy($propertyId);
        return redirect()->route('admin.properties');
    }

    //значения свойств
    public function showPropertyValues($propertyId)
    {
        $values = Property::findOrFail($propertyId)->values;
        return view('admin.properties.values.index', compact(['values', 'propertyId']));
    }

    public function showEditPropertyValue($valueId)
    {
        $value = Value::findOrFail($valueId);
        return view('admin.properties.values.form', compact('value'));
    }

    public function editPropertyValue(Request $request, $valueId)
    {
        $value = Value::findOrFail($valueId);

        $value->name = $request->get('name');
        $value->save();

        $propertyId = $value->property_id;
        $values = Property::findOrFail($propertyId)->values;
        return view('admin.properties.values.index', compact(['values', 'propertyId']));
    }

    public function showCreatePropertyValue($propertyId)
    {
        return view('admin.properties.values.form', compact('propertyId'));
    }

    public function createPropertyValue(Request $request, $propertyId)
    {
        Value::create([
            'property_id' => $propertyId,
            'name' => $request->get('name')
        ]);

        $values = Property::findOrFail($propertyId)->values;
        return view('admin.properties.values.index', compact(['values', 'propertyId']));
    }

    public function deletePropertyValue($valueId)
    {
        $propertyId = Value::findOrFail($valueId)->property_id;

        Value::destroy($valueId);

        $values = Property::findOrFail($propertyId)->values;
        return view('admin.properties.values.index', compact(['values', 'propertyId']));
    }
}
