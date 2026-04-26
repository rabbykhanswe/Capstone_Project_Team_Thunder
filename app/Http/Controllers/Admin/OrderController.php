<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\NotificationService;
use App\Models\Notification;

class OrderController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', fn($sq) => $sq->where('fname', 'like', '%' . $search . '%')
                                                      ->orWhere('lname', 'like', '%' . $search . '%'));
            });
        }

        $orders = $query->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.plant', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);

        $order    = Order::with('user')->findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;

        if ($request->status === 'shipped') {
            $order->shipped_at       = now();
            $order->tracking_number  = $request->tracking_number;
        }
        if ($request->status === 'delivered') {
            $order->delivered_at   = now();
            $order->payment_status = 'paid';
        }

        $order->save();

        // Send notifications on status change
        if ($order->user && $oldStatus !== $request->status) {
            // Send in-app notification
            Notification::orderStatusChanged($order);
            
            // Send SMS notification
            match ($request->status) {
                'shipped'   => $this->notificationService->sendShippingUpdate($order->user, $order),
                'delivered' => $this->notificationService->sendDeliveryConfirmation($order->user, $order),
                'cancelled' => $this->notificationService->sendOrderCancellation($order->user, $order),
                default     => null,
            };
        }

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status) . '.');
    }
}
