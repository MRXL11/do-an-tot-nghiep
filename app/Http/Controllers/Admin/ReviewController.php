<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product.category']) // Load quan hệ để tránh lỗi N+1
                        ->latest()
                        ->paginate(5);

        return view('admin.others_menu.reviews', compact('reviews'));
    }


    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->status = 'approved';
        $review->save();

        return redirect()->back()->with('success', 'Đã duyệt đánh giá.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Đã xoá đánh giá.');
    }
    // Store a new review from frontend form
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(), // Use auth() instead of Auth::id() for consistency
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // Waiting for admin approval
        ]);

        return redirect()->back()->with('success', 'Đánh giá đã được gửi, đang chờ duyệt.');
    }
}
