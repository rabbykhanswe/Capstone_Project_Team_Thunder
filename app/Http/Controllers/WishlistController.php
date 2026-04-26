<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Plant;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
                                 ->with('plant')
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request, $plantId)
    {
        $plant = Plant::findOrFail($plantId);

        $existingWishlist = Wishlist::where('user_id', Auth::id())
                                   ->where('plant_id', $plantId)
                                   ->first();

        if ($existingWishlist) {
            return response()->json([
                'success' => false,
                'message' => 'This plant is already in your wishlist!'
            ]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'plant_id' => $plantId
        ]);

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Plant added to wishlist successfully!',
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function remove($plantId)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
                               ->where('plant_id', $plantId)
                               ->first();

        if (!$wishlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in wishlist!'
            ]);
        }

        $wishlistItem->delete();

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist!',
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function toggle(Request $request, $plantId)
    {

        $isInWishlist = Wishlist::isInWishlist(Auth::id(), $plantId);

        if ($isInWishlist) {
            $this->remove($plantId);
            $isWishlisted = false;
            $message = 'Plant removed from wishlist!';
        } else {
            $this->add($request, $plantId);
            $isWishlisted = true;
            $message = 'Plant added to wishlist!';
        }

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_wishlisted' => $isWishlisted,
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function getWishlistCount()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        return response()->json(['count' => $count]);
    }

    public function checkWishlistStatus($plantId)
    {
        $isWishlisted = Wishlist::isInWishlist(Auth::id(), $plantId);
        return response()->json(['is_wishlisted' => $isWishlisted]);
    }

    public function clear()
    {
        Wishlist::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
}
