<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $quantity) {
            $plant = Plant::find($id);
            if ($plant) {
                $itemTotal = $plant->price * $quantity;
                $subtotal += $itemTotal;
                
                $cartItems[] = [
                    'plant' => $plant,
                    'quantity' => $quantity,
                    'item_total' => $itemTotal
                ];
            }
        }

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request, $id)
    {
        $plant = Plant::findOrFail($id);
        
        if ($plant->stock_count < 1) {
            return response()->json([
                'success' => false,
                'message' => 'This product is out of stock!'
            ]);
        }

        $cart = session()->get('cart', []);
        $quantity = $request->get('quantity', 1);

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id] + $quantity;
            if ($newQuantity > $plant->stock_count) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $plant->stock_count . ' items available in stock!'
                ]);
            }
            $cart[$id] = $newQuantity;
        } else {
            if ($quantity > $plant->stock_count) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only ' . $plant->stock_count . ' items available in stock!'
                ]);
            }
            $cart[$id] = $quantity;
        }

        session()->put('cart', $cart);

        $cartCount = array_sum($cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $plant = Plant::findOrFail($id);
        $quantity = $request->quantity;

        if ($quantity > $plant->stock_count) {
            return response()->json([
                'success' => false,
                'message' => 'Only ' . $plant->stock_count . ' items available in stock!'
            ]);
        }

        $cart = session()->get('cart', []);
        $cart[$id] = $quantity;
        session()->put('cart', $cart);

        $itemTotal = $plant->price * $quantity;
        $subtotal = $this->calculateSubtotal($cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'item_total' => $itemTotal,
            'subtotal' => $subtotal
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $subtotal = $this->calculateSubtotal($cart);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart!',
            'subtotal' => $subtotal
        ]);
    }

    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully!'
        ]);
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = array_sum($cart);

        return response()->json(['count' => $count]);
    }

    private function calculateSubtotal($cart)
    {
        $subtotal = 0;
        
        foreach ($cart as $id => $quantity) {
            $plant = Plant::find($id);
            if ($plant) {
                $subtotal += $plant->price * $quantity;
            }
        }
        
        return $subtotal;
    }
}
