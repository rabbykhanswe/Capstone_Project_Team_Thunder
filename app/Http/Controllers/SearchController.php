<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $environment = $request->get('environment', '');
        $plantType = $request->get('plant_type', '');
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', 999999);
        $category = $request->get('category', '');

        $plants = Plant::query();

        if (!empty($query)) {
            $plants->search($query);
        }

        if (!empty($environment)) {
            $plants->byEnvironment($environment);
        }

        if (!empty($plantType)) {
            $plants->byPlantType($plantType);
        }

        if ($minPrice > 0 || $maxPrice < 999999) {
            $plants->inPriceRange($minPrice, $maxPrice);
        }

        if (!empty($category)) {
            $plants->where('category', $category);
        }

        $plants = $plants->where('stock_count', '>', 0)
                         ->orderBy('name')
                         ->paginate(12);

        $environments = ['indoor', 'outdoor', 'both'];
        $plantTypes = ['plant', 'succulent', 'tool', 'herb', 'flowering', 'foliage'];
        $categories = Plant::distinct()->pluck('category')->filter();

        return view('search.index', compact('plants', 'query', 'environments', 'plantTypes', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return response()->json(['plants' => [], 'total' => 0]);
        }

        $plants = Plant::search($query)
                       ->where('stock_count', '>', 0)
                       ->limit(10)
                       ->get(['id', 'name', 'price', 'image', 'category', 'stock_count']);

        return response()->json([
            'plants' => $plants,
            'total' => $plants->count()
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('term', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Plant::where('name', 'LIKE', $query . '%')
                           ->orWhere('category', 'LIKE', $query . '%')
                           ->where('stock_count', '>', 0)
                           ->limit(8)
                           ->get(['id', 'name', 'price', 'image', 'category', 'stock_count']);

        return response()->json($suggestions);
    }
}
