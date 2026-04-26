<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plant;
use App\Services\NotificationService;

class CheckoutController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Step 1: Address confirmation
    public function step1()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $user     = auth()->user();
        $cartItems = $this->buildCartItems($cart);
        $subtotal  = collect($cartItems)->sum('item_total');

        return view('checkout.step1', compact('user', 'cartItems', 'subtotal'));
    }

    public function postStep1(Request $request)
    {
        $validated = $request->validate([
            'shipping_name'        => 'required|string|max:100',
            'shipping_phone'       => 'required|string|max:20',
            'shipping_address'     => 'required|string|max:255',
            'shipping_city'        => 'required|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
        ]);

        session(['checkout_address' => $validated]);
        return redirect()->route('checkout.step2');
    }

    // Step 2: Payment method
    public function step2()
    {
        if (!session('checkout_address')) {
            return redirect()->route('checkout.step1');
        }

        $cart      = session('cart', []);
        $cartItems = $this->buildCartItems($cart);
        $subtotal  = collect($cartItems)->sum('item_total');
        $shippingFee = 60;
        $total     = $subtotal + $shippingFee;

        return view('checkout.step2', compact('cartItems', 'subtotal', 'shippingFee', 'total'));
    }

    public function postStep2(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash_on_delivery,bkash,nagad,rocket',
        ]);

        session(['checkout_payment' => $validated]);
        return redirect()->route('checkout.step3');
    }

    // Step 3: Order review
    public function step3()
    {
        if (!session('checkout_address') || !session('checkout_payment')) {
            return redirect()->route('checkout.step1');
        }

        $cart        = session('cart', []);
        $cartItems   = $this->buildCartItems($cart);
        $subtotal    = collect($cartItems)->sum('item_total');
        $shippingFee = 60;
        $total       = $subtotal + $shippingFee;
        $address     = session('checkout_address');
        $payment     = session('checkout_payment');

        return view('checkout.step3', compact(
            'cartItems', 'subtotal', 'shippingFee', 'total', 'address', 'payment'
        ));
    }

    // Place the order
    public function placeOrder(Request $request)
    {
        if (!session('checkout_address') || !session('checkout_payment')) {
            return redirect()->route('checkout.step1');
        }

        $cart    = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $cartItems   = $this->buildCartItems($cart);
        $subtotal    = collect($cartItems)->sum('item_total');
        $shippingFee = 60;
        $total       = $subtotal + $shippingFee;
        $address     = session('checkout_address');
        $payment     = session('checkout_payment');
        $user        = auth()->user();

        $order = Order::create([
            'order_number'         => Order::generateOrderNumber(),
            'user_id'              => $user->id,
            'status'               => 'pending',
            'subtotal'             => $subtotal,
            'shipping_fee'         => $shippingFee,
            'total_amount'         => $total,
            'shipping_name'        => $address['shipping_name'],
            'shipping_phone'       => $address['shipping_phone'],
            'shipping_address'     => $address['shipping_address'],
            'shipping_city'        => $address['shipping_city'],
            'shipping_postal_code' => $address['shipping_postal_code'] ?? null,
            'payment_method'       => $payment['payment_method'],
            'payment_status'       => 'unpaid',
            'notes'                => $request->notes,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'plant_id'   => $item['plant']->id,
                'plant_name' => $item['plant']->name,
                'quantity'   => $item['quantity'],
                'unit_price' => $item['plant']->price,
                'item_total' => $item['item_total'],
            ]);


            $item['plant']->decrement('stock_count', $item['quantity']);
        }


        $this->notificationService->sendOrderConfirmation($user, $order);


        session()->forget(['cart', 'checkout_address', 'checkout_payment']);

        return redirect()->route('checkout.success', $order->id);
    }

    public function success($orderId)
    {
        $order = Order::with('items')->where('user_id', auth()->id())->findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }

    private function buildCartItems(array $cart): array
    {
        $items = [];
        foreach ($cart as $id => $quantityData) {
            $quantity = is_array($quantityData) ? ($quantityData['quantity'] ?? $quantityData) : $quantityData;
            $plant = Plant::find($id);
            if ($plant) {
                $items[] = [
                    'plant'      => $plant,
                    'quantity'   => (int) $quantity,
                    'item_total' => $plant->price * (int) $quantity,
                ];
            }
        }
        return $items;
    }
}
