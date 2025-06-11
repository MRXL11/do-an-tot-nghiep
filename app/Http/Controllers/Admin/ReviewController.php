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
}
