<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $notifications = Notification::forUser($user->id)
            ->latest()
            ->take(10)
            ->get(['id', 'type', 'title', 'message', 'data', 'created_at', 'read_at']);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Notification::forUser($user->id)->unread()->count()
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::forUser(auth()->id())
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
