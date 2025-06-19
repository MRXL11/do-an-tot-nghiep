<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng của người dùng
     */
    public function index()
    {
        $cartItems = Cart::with('productVariant.product')
                        ->where('user_id', Auth::id())
                        ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->productVariant->price * $item->quantity;
        });

        $shipping = 0; // Bỏ phí ship như yêu cầu
        $total = $subtotal + $shipping;

        return view('client.pages.cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để mua hàng!');
        }

        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::find($request->product_variant_id);

        if ($variant->stock_quantity < $request->quantity) {
            return back()->with('error', 'Số lượng vượt quá tồn kho!');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_variant_id', $variant->id)
                    ->first();

        $currentQty = $cart ? $cart->quantity : 0;
        $newQty = $currentQty + $request->quantity;

        if ($newQty > $variant->stock_quantity) {
            return back()->with('error', 'Tổng số lượng trong giỏ vượt quá tồn kho!');
        }

        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_variant_id' => $variant->id],
            ['quantity' => $newQty]
        );

        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }


    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1' // Không chấp nhận 0
        ]);

        $cart = Cart::find($request->cart_id);

        // Chỉ cho phép cập nhật giỏ hàng của chính user đang đăng nhập
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Không có quyền sửa giỏ hàng này!'], 403);
        }

        $variant = $cart->productVariant;

        // Kiểm tra sản phẩm có tồn tại không
        if (!$variant) {
            return response()->json(['error' => 'Không tìm thấy phiên bản sản phẩm!'], 404);
        }

        // Kiểm tra tồn kho
        if ($variant->stock_quantity < $request->quantity) {
            return response()->json(['error' => 'Không đủ hàng trong kho! Chỉ còn ' . $variant->stock_quantity . ' sản phẩm.'], 400);
        }

        // Cập nhật số lượng
        $cart->quantity = $request->quantity;
        $cart->save();

        $itemTotal = $variant->price * $cart->quantity;

        // Tính lại tổng phụ và tổng cộng
        $cartItems = Cart::with('productVariant.product')
                        ->where('user_id', Auth::id())
                        ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->productVariant->price * $item->quantity;
        });

        $shipping = 0; // Bỏ phí ship
        $total = $subtotal + $shipping;

        return response()->json([
            'message' => 'Cập nhật giỏ hàng thành công!',
            'itemTotal' => round($itemTotal, 2),
            'subtotal' => round($subtotal, 2),
            'total' => round($total, 2),
            'stock_quantity' => $variant->stock_quantity
        ]);
    }

    /**
     * Xóa 1 sản phẩm trong giỏ hàng
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cart = Cart::find($request->cart_id);

        if ($cart && $cart->user_id == Auth::id()) {
            $cart->delete();

            $newCount = Cart::where('user_id', Auth::id())->count();

            return response()->json([
                'success' => true,
                'newCartCount' => $newCount
            ]);
        }

        return response()->json(['error' => 'Không thể xóa sản phẩm này!'], 403);
    }

    /**
     * Xóa nhiều sản phẩm được chọn trong giỏ hàng
     */
    public function removeSelected(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array'
        ]);

        // Chỉ xóa sản phẩm thuộc user hiện tại
        Cart::whereIn('id', $request->cart_ids)
            ->where('user_id', Auth::id())
            ->delete();

        // Đếm lại số sản phẩm còn lại trong giỏ
        $newCount = Cart::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'newCartCount' => $newCount
        ]);
    }

    public function addAjax(Request $request)
{
    $request->validate([
        'product_variant_id' => 'required|exists:product_variants,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $variant = ProductVariant::find($request->product_variant_id);

    if ($variant->stock_quantity < $request->quantity) {
        return response()->json(['success' => false, 'message' => 'Số lượng vượt quá tồn kho!']);
    }

    $cart = Cart::updateOrCreate(
        ['user_id' => Auth::id(), 'product_variant_id' => $variant->id],
        ['quantity' => DB::raw('quantity + '.$request->quantity)]
    );

    // Đếm tổng sản phẩm trong giỏ hàng 
    $cartCount = Cart::where('user_id', Auth::id())->count();

    return response()->json(['success' => true, 'message' => 'Đã thêm vào giỏ!', 'cart_count' => $cartCount]);
}

}
