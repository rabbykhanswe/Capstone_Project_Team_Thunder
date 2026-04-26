<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                    ->with('items')
                    ->latest()
                    ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.plant')
                    ->where('user_id', auth()->id())
                    ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function invoice($id)
    {
        $order = Order::with('items.plant')
                    ->where('user_id', auth()->id())
                    ->findOrFail($id);

        return view('orders.invoice', compact('order'));
    }
}
