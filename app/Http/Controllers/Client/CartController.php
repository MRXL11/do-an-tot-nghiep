<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\Product;
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
        $cartItems = collect([]);
        $subtotal = 0;
        $total = 0;

        if (Auth::check()) {
            // Lấy danh sách sản phẩm trong giỏ hàng
            $cartItems = Cart::with(['productVariant' => function ($query) {
                $query->select('id', 'product_id', 'price', 'stock_quantity', 'status', 'image', 'size', 'color');
            }, 'productVariant.product' => function ($query) {
                $query->select('id', 'name');
            }])
                ->where('user_id', Auth::id())
                ->get();

            // Lấy danh sách product_variant_id từ các đơn hàng thanh toán online/bank_transfer nhưng failed
            $lockedVariantIds = OrderDetail::whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                    ->whereIn('payment_method', ['online', 'bank_transfer'])
                    ->whereIn('payment_status', ['pending', 'failed']);
            })
                ->pluck('product_variant_id')
                ->toArray();

            // Đánh dấu các item trong giỏ hàng nếu chúng nằm trong đơn hàng failed
            foreach ($cartItems as $item) {
                $item->is_locked = in_array($item->product_variant_id, $lockedVariantIds);
            }

            // Tính tổng giá trị
            $subtotal = $cartItems->sum(function ($item) {
                // Chỉ tính các item có status active và không bị khóa
                if ($item->productVariant->status === 'active' && !$item->is_locked) {
                    return $item->productVariant->price * $item->quantity;
                }
                return 0;
            });

            $total = $subtotal;
        }

        // Chuẩn bị dữ liệu cho JavaScript
        $cartItemsForJs = $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'status' => $item->productVariant->status ?? 'inactive',
                'is_locked' => $item->is_locked ?? false
            ];
        });

        return view('client.pages.cart', compact('cartItems', 'subtotal', 'total', 'cartItemsForJs'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::find($request->product_variant_id);

        if (!$variant) {
            return back()->with('error', 'Sản phẩm này không còn tồn tại!');
        }

        // Kiểm tra trạng thái
        if ($variant->status !== 'active') {
            return back()->with('error', 'Sản phẩm này hiện không còn hoạt động!');
        }

        // Chỉ kiểm tra nếu sản phẩm này từng nằm trong đơn thanh toán online/bank_transfer nhưng đã failed
        $isLocked = OrderDetail::where('product_variant_id', $variant->id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                    ->whereIn('payment_method', ['online', 'bank_transfer'])
                    ->where('payment_status', 'failed');
            })->exists();

        if ($isLocked) {
            return back()->with('error', 'Sản phẩm này đã từng được đặt nhưng thanh toán thất bại. Vui lòng chọn lại hoặc liên hệ hỗ trợ.');
        }

        // Kiểm tra tồn kho
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

        // Thêm hoặc cập nhật cart
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
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::findOrFail($request->cart_id);

        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Không có quyền sửa giỏ hàng này!'], 403);
        }

        $variant = $cart->productVariant;
        if (!$variant) {
            return response()->json(['error' => 'Sản phẩm này không còn tồn tại!'], 404);
        }

        // Kiểm tra trạng thái active
        if ($variant->status !== 'active') {
            return response()->json(['error' => 'Sản phẩm này đã ngừng bán!'], 400);
        }

        if ($variant->stock_quantity < $request->quantity) {
            return response()->json(['error' => 'Không đủ hàng trong kho! Chỉ còn ' . $variant->stock_quantity . ' sản phẩm.'], 400);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        $itemTotal = $variant->price * $cart->quantity;

        $cartItems = Cart::with('productVariant.product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->productVariant->price * $item->quantity;
        });

        $total = $subtotal;

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

    /**
     * Thêm sản phẩm vào giỏ bằng Ajax
     */
    public function addAjax(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $variant = ProductVariant::find($request->product_variant_id);
        if (!$variant) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm này không còn tồn tại!']);
        }

        // Kiểm tra trạng thái active
        if ($variant->status !== 'active') {
            return response()->json(['success' => false, 'message' => 'Sản phẩm này đã ngừng bán!']);
        }

        // Chỉ kiểm tra nếu sản phẩm này từng nằm trong đơn thanh toán online/bank_transfer nhưng đã failed
        $isLocked = OrderDetail::where('product_variant_id', $variant->id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                    ->whereIn('payment_method', ['online', 'bank_transfer'])
                    ->whereIn('payment_status', ['pending', 'failed']);
            })->exists();

        // Lấy đơn hàng có variant này (mới nhất) và failed
        $failedOrder = Order::where('user_id', Auth::id())
            ->whereIn('payment_method', ['online', 'bank_transfer'])
            ->whereIn('payment_status', ['pending', 'failed'])
            ->whereHas('orderDetails', function ($q) use ($variant) {
                $q->where('product_variant_id', $variant->id);
            })->latest()->first();

        if ($isLocked) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm tồn tại trong đơn hàng chưa thanh toán, vui lòng thanh toán trước khi tiếp tục!',
                'order_id' => $failedOrder->id,
            ]);
        }

        // Kiểm tra tồn kho
        if ($variant->stock_quantity < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Số lượng vượt quá tồn kho!']);
        }

        // Kiểm tra đã có trong giỏ chưa
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_variant_id', $variant->id)
            ->first();

        $currentQty = $cart ? $cart->quantity : 0;
        $newQty = $currentQty + $request->quantity;

        if ($newQty > $variant->stock_quantity) {
            return response()->json(['success' => false, 'message' => 'Tổng số lượng trong giỏ vượt quá tồn kho!']);
        }

        // Cập nhật giỏ hàng
        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_variant_id' => $variant->id],
            ['quantity' => $newQty]
        );

        $cartCount = Cart::where('user_id', Auth::id())->count(); // Đếm lại giỏ

        return response()->json(['success' => true, 'message' => 'Đã thêm vào giỏ hàng!', 'cart_count' => $cartCount]);
    }
}
