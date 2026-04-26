<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Order;

class ReviewController extends Controller
{

    public function store(Request $request, $plantId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);


        $hasPurchased = Order::where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereHas('items', fn($q) => $q->where('plant_id', $plantId))
            ->exists();


        $existing = Review::where('user_id', auth()->id())
                          ->where('plant_id', $plantId)
                          ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this plant.');
        }

        Review::create([
            'user_id'  => auth()->id(),
            'plant_id' => $plantId,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
            'status'   => $hasPurchased ? 'approved' : 'pending',
        ]);

        $message = $hasPurchased
            ? 'Your review has been published!'
            : 'Your review has been submitted and is awaiting moderation.';

        return back()->with('success', $message);
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
