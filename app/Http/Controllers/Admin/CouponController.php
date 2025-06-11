<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query();

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $coupons = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(StoreCouponRequest $request)
    {
        Coupon::create($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Thêm coupon thành công!');
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->validated());

        return redirect()->route('admin.coupons.index')->with('success', 'Cập nhật coupon thành công!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Xóa coupon thành công!');
    }

    public function trashed(Request $request)
    {
        $query = Coupon::onlyTrashed();

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        $coupons = $query->orderBy('deleted_at', 'desc')->paginate(10);

        return view('admin.coupons.trashed', compact('coupons'));
    }

    public function restore($id)
    {
        $coupon = Coupon::onlyTrashed()->findOrFail($id);
        $coupon->restore();

        return redirect()->route('admin.admin.coupons.trashed')->with('success', 'Khôi phục coupon thành công!');
    }

    // public function forceDelete($id)
    // {
    //     $coupon = Coupon::onlyTrashed()->findOrFail($id);
    //     $coupon->forceDelete();

    //     return redirect()->route('admin.admin.coupons.trashed')->with('success', 'Xóa vĩnh viễn coupon thành công!');
    // }
    // xóa vĩnh viễn coupon không cần thiết
}