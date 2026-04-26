<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ContactInquiry;
use App\Models\Notification;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('user', 'plant')->latest();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $reviews = $query->paginate(20);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected,pending']);
        $review = Review::findOrFail($id);
        $review->update(['status' => $request->status]);

        // Send notification if review is approved
        if ($request->status === 'approved') {
            Notification::reviewApproved($review);
        }

        return back()->with('success', 'Review ' . $request->status . '.');
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return back()->with('success', 'Review deleted.');
    }

    // Contact inquiries management
    public function inquiries(Request $request)
    {
        $query = ContactInquiry::latest();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $inquiries = $query->paginate(20);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function replyInquiry(Request $request, $id)
    {
        $request->validate(['admin_reply' => 'required|string|max:2000']);
        ContactInquiry::findOrFail($id)->update([
            'admin_reply' => $request->admin_reply,
            'status'      => 'replied',
        ]);
        return back()->with('success', 'Reply saved.');
    }

    public function markInquiryRead($id)
    {
        $inquiry = ContactInquiry::findOrFail($id);
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'read']);
        }
        return back();
    }
}
