<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Plant;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders       = Order::where('user_id', $user->id)->latest()->get();
        $recentOrders = $orders->take(5);

        $totalOrders    = $orders->count();
        $totalSpent     = $orders->whereNotIn('status', ['cancelled'])->sum('total_amount');
        $pendingOrders  = $orders->whereIn('status', ['pending', 'processing'])->count();
        $deliveredOrders = $orders->where('status', 'delivered')->count();

        $wishlistItems  = Wishlist::where('user_id', $user->id)
                            ->with('plant')
                            ->latest()
                            ->take(6)
                            ->get();
        $wishlistCount  = Wishlist::where('user_id', $user->id)->count();

        $cartCount = session('cart') ? array_sum(session('cart')) : 0;

        return view('account.dashboard', compact(
            'user', 'recentOrders', 'totalOrders', 'totalSpent',
            'pendingOrders', 'deliveredOrders', 'wishlistItems', 'wishlistCount', 'cartCount'
        ));
    }
}
