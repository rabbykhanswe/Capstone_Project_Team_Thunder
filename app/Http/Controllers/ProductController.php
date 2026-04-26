<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Review;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Plant::where('stock_count', '>', 0);

        if ($request->has('environment')) {
            $query->byEnvironment($request->environment);
        }

        if ($request->has('plant_type')) {
            $query->byPlantType($request->plant_type);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->inPriceRange($request->min_price, $request->max_price);
        }

        $plants = $query->orderBy('name')->paginate(12);

        $environments = ['indoor', 'outdoor', 'both'];
        $plantTypes = ['plant', 'succulent', 'tool', 'herb', 'flowering', 'foliage'];
        $categories = Category::active()->ordered()->get();

        return view('products.index', compact('plants', 'environments', 'plantTypes', 'categories'));
    }

    public function show($id)
    {
        $plant = Plant::findOrFail($id);
        $relatedPlants = Plant::where('category', $plant->category)
                            ->where('id', '!=', $plant->id)
                            ->where('stock_count', '>', 0)
                            ->limit(4)
                            ->get();

        $reviews = Review::with('user')
                    ->where('plant_id', $id)
                    ->where('status', 'approved')
                    ->latest()
                    ->get();

        $avgRating    = $reviews->avg('rating');
        $userReview   = auth()->check()
                        ? Review::where('user_id', auth()->id())->where('plant_id', $id)->first()
                        : null;

        return view('products.show', compact('plant', 'relatedPlants', 'reviews', 'avgRating', 'userReview'));
    }

    public function filter(Request $request)
    {
        $query = Plant::where('stock_count', '>', 0);

        if ($request->has('environment')) {
            $query->byEnvironment($request->environment);
        }

        if ($request->has('plant_type')) {
            $query->byPlantType($request->plant_type);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->inPriceRange($request->min_price, $request->max_price);
        }

        $plants = $query->orderBy('name')->get();

        return response()->json([
            'plants' => $plants,
            'total' => $plants->count()
        ]);
    }
}
