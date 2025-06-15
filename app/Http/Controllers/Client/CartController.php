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
    // Hiển thị giỏ hàng
    public function index()
    {
        $cartItems = Cart::with('productVariant.product')
                        ->where('user_id', Auth::id())
                        ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->productVariant->price * $item->quantity;
        });

        $shipping = 1; // cố định tạm
        $total = $subtotal + $shipping;

        return view('client.pages.cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::find($request->product_variant_id);

        if ($variant->stock_quantity < $request->quantity) {
            return back()->with('error', 'Số lượng vượt quá tồn kho!');
        }

        $cart = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_variant_id' => $variant->id],
            ['quantity' => DB::raw('quantity + '.$request->quantity)]
        );

        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }
    // update
    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::find($request->cart_id);
        $variant = $cart->productVariant;

        if ($variant->stock_quantity < $request->quantity) {
            return response()->json(['error' => 'Không đủ hàng trong kho!'], 400);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        // Tính lại tổng tiền sản phẩm, tổng tiền giỏ
        $itemTotal = $cart->quantity * $variant->price;

        $cartItems = Cart::with('productVariant.product')
                        ->where('user_id', Auth::id())
                        ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->productVariant->price * $item->quantity;
        });

        $shipping = 1;
        $total = $subtotal + $shipping;

        return response()->json([
            'itemTotal' => number_format($itemTotal, 2),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2)
        ]);
    }



    // Xoá sản phẩm
    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id'
        ]);

        Cart::destroy($request->cart_id);

        return back()->with('success', 'Đã xoá sản phẩm');
    }

    // Áp dụng mã giảm giá
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)
                        ->where('status', 'active')
                        ->where('start_date', '<=', now())
                        ->where('end_date', '>=', now())
                        ->first();

        if (!$coupon) {
            return back()->with('error', 'Mã giảm giá không hợp lệ');
        }

        Session::put('coupon', $coupon);

        return back()->with('success', 'Áp dụng mã giảm giá thành công');
    }
}
