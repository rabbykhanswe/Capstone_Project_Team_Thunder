<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Category;

class PlantController extends Controller
{

    
    public function index()
    {
        $plants = Plant::orderBy('category')->orderBy('name')->paginate(10);
        return view('admin.plants.index', compact('plants'));
    }

    


    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.plants.create', compact('categories'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_count' => 'required|integer|min:0',
            'category' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_seasonal' => 'boolean',
            'season' => 'nullable|required_if:is_seasonal,1|string|max:20',
            'care_instructions' => 'nullable|string',
            'sunlight_requirements' => 'nullable|string|max:100',
            'water_requirements' => 'nullable|string|max:100',
            'environment' => 'required|in:indoor,outdoor,both',
            'plant_type' => 'required|in:plant,succulent,tool,herb,flowering,foliage',
            'image_gallery' => 'nullable|array',
            'image_gallery.*' => 'string'
        ]);

        $data = $request->all();
        

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/plants'), $imageName);
            $data['image'] = $imageName;
        }

        Plant::create($data);

        return redirect()->route('admin.plants.index')->with('success', 'Plant added successfully!');
    }






    public function edit($id)
    {
        $plant = Plant::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.plants.edit', compact('plant', 'categories'));
    }





    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_count' => 'required|integer|min:0',
            'category' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_seasonal' => 'boolean',
            'season' => 'nullable|required_if:is_seasonal,1|string|max:20',
            'care_instructions' => 'nullable|string',
            'sunlight_requirements' => 'nullable|string|max:100',
            'water_requirements' => 'nullable|string|max:100',
            'environment' => 'required|in:indoor,outdoor,both',
            'plant_type' => 'required|in:plant,succulent,tool,herb,flowering,foliage',
            'image_gallery' => 'nullable|array',
            'image_gallery.*' => 'string'
        ]);

        $plant = Plant::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {

            if ($plant->image) {
                $oldImagePath = public_path('images/plants/' . $plant->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/plants'), $imageName);
            $data['image'] = $imageName;
        } else {
            unset($data['image']);
        }

        $plant->update($data);

        return redirect()->route('admin.plants.index')->with('success', 'Plant updated successfully!');
    }





    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        

        if ($plant->image) {
            $imagePath = public_path('images/plants/' . $plant->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $plant->delete();

        return redirect()->route('admin.plants.index')->with('success', 'Plant deleted successfully!');
    }





    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock_count' => 'required|integer|min:0'
        ]);

        $plant = Plant::findOrFail($id);
        $plant->stock_count = $request->stock_count;
        $plant->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Stock updated successfully!']);
        }

        return back()->with('success', 'Stock updated successfully!');
    }



    
    public function updatePrice(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);

        $plant = Plant::findOrFail($id);
        $plant->price = $request->price;
        $plant->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Price updated successfully!']);
        }

        return back()->with('success', 'Price updated successfully!');
    }
}
