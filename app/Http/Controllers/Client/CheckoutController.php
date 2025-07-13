<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thanh toán.');
        }

        $rawIds = explode(',', $request->query('cart_item_ids', ''));
        $validIds = array_filter($rawIds, function ($id) {
            return is_numeric($id) && intval($id) > 0;
        });

        if (empty($validIds)) {
            return redirect()->route('cart.index')->with('warning', 'Danh sách sản phẩm không hợp lệ.');
        }

        $cartItems = Cart::with(['productVariant.product'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $validIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Không tìm thấy sản phẩm nào phù hợp.');
        }

        if (count($validIds) !== $cartItems->count()) {
            session()->flash('warning', 'Một số sản phẩm bạn chọn đã ngừng bán hoặc không còn tồn tại.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->productVariant->price * $item->quantity;
        });

        // Lấy thông tin mã giảm giá từ session
        $coupon = session('coupon');
        $discount = 0;
        if ($coupon) {
            $discount = $this->calculateDiscount($coupon, $subtotal, $cartItems);
        }

        $shippingAddresses = ShippingAddress::selectRaw('MIN(id) as id, name, phone_number, address, ward, district, city')
            ->where('user_id', Auth::id())
            ->groupBy('name', 'phone_number', 'address', 'ward', 'district', 'city')
            ->get()
            ->map(function ($address) {
                $address->full_address = implode(', ', array_filter([
                    $address->address,
                    $address->ward,
                    $address->district,
                    $address->city
                ]));
                return $address;
            });

        return view('client.pages.checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $subtotal + 20000 - $discount,
            'user' => (object) ['shippingAddresses' => $shippingAddresses],
            'coupon' => $coupon ? $coupon->code : null,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
            'cart_item_ids' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.',
            ], 422);
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã đạt giới hạn sử dụng.',
            ], 422);
        }

        $userUsage = Order::where('user_id', Auth::id())
            ->where('coupon_id', $coupon->id)
            ->count();
        if ($coupon->user_usage_limit !== null && $userUsage >= $coupon->user_usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng mã giảm giá này quá số lần cho phép.',
            ], 422);
        }

        $cartItemIds = array_filter(explode(',', $request->cart_item_ids), function ($id) {
            return is_numeric($id) && intval($id) > 0;
        });

        if (empty($cartItemIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống hoặc không hợp lệ.',
            ], 422);
        }

        $cartItems = Cart::with(['productVariant.product'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartItemIds)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->productVariant->price * $item->quantity;
        });

        if ($coupon->min_order_value !== null && $subtotal < $coupon->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Tổng giá trị đơn hàng chưa đạt mức tối thiểu ' . number_format($coupon->min_order_value, 0, ',', '.') . ' ₫.',
            ], 422);
        }

        $isApplicable = false;
        $applicableCategories = $coupon->applicable_categories ? json_decode($coupon->applicable_categories, true) : [];
        $applicableProducts = $coupon->applicable_products ? json_decode($coupon->applicable_products, true) : [];

        if (empty($applicableCategories) && empty($applicableProducts)) {
            $isApplicable = true;
        } else {
            foreach ($cartItems as $item) {
                $product = $item->productVariant->product;
                if (
                    (empty($applicableCategories) || in_array($product->category_id, $applicableCategories)) ||
                    (empty($applicableProducts) || in_array($product->id, $applicableProducts))
                ) {
                    $isApplicable = true;
                    break;
                }
            }
        }

        if (!$isApplicable) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không áp dụng cho các sản phẩm trong giỏ hàng.',
            ], 422);
        }

        $discount = $this->calculateDiscount($coupon, $subtotal, $cartItems);
        session(['coupon' => $coupon]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount' => $discount,
            'total' => $subtotal + 20000 - $discount,
            'formatted_discount' => number_format($discount, 0, ',', '.') . ' ₫',
            'formatted_total' => number_format($subtotal + 20000 - $discount, 0, ',', '.') . ' ₫',
        ]);
    }

    protected function calculateDiscount($coupon, $subtotal, $cartItems)
    {
        $discount = 0;
        $applicableCategories = $coupon->applicable_categories ? json_decode($coupon->applicable_categories, true) : [];
        $applicableProducts = $coupon->applicable_products ? json_decode($coupon->applicable_products, true) : [];
        $applicableSubtotal = 0;

        if (empty($applicableCategories) && empty($applicableProducts)) {
            $applicableSubtotal = $subtotal;
        } else {
            foreach ($cartItems as $item) {
                $product = $item->productVariant->product;
                if (
                    (empty($applicableCategories) || in_array($product->category_id, $applicableCategories)) ||
                    (empty($applicableProducts) || in_array($product->id, $applicableProducts))
                ) {
                    $applicableSubtotal += $item->productVariant->price * $item->quantity;
                }
            }
        }

        if ($coupon->discount_type === 'percent') {
            $discount = ($applicableSubtotal * $coupon->discount_value) / 100;
            if ($coupon->max_discount !== null && $discount > $coupon->max_discount) {
                $discount = $coupon->max_discount;
            }
        } else {
            $discount = min($coupon->discount_value, $applicableSubtotal);
        }

        return $discount;
    }

    public function submit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thanh toán.');
        }

        $request->validate([
            'paymentMethod' => 'required|in:cod,momo,card',
            'name' => [
                'required_without:shipping_address_id',
                'string',
                'max:100',
                'min:2',
                'regex:/^[\p{L}\s]+$/u',
            ],
            'phone_number' => [
                'required_without:shipping_address_id',
                'string',
                'max:20',
                'regex:/^(0|\+84)[0-9]{9,10}$/',
            ],
            'address' => [
                'required_without:shipping_address_id',
                'string',
                'max:255',
                'regex:/^[\p{L}\p{N}\s,.-]+$/u',
            ],
            'ward' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[\p{L}\p{N}\s]+$/u',
            ],
            'district' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[\p{L}\p{N}\s]+$/u',
            ],
            'city' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[\p{L}\p{N}\s]+$/u',
            ],
            'shipping_address_id' => 'nullable|exists:shipping_addresses,id',
            'coupon_code' => 'nullable|string|max:50',
        ], [
            'paymentMethod.required' => 'Vui lòng chọn phương thức thanh toán.',
            'name.required_without' => 'Vui lòng nhập họ tên người nhận hoặc chọn địa chỉ có sẵn.',
            'name.regex' => 'Họ và tên chỉ được chứa chữ cái và dấu cách.',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
            'phone_number.required_without' => 'Vui lòng nhập số điện thoại hoặc chọn địa chỉ có sẵn.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (ví dụ: 0901234567 hoặc +84901234567).',
            'address.required_without' => 'Vui lòng nhập địa chỉ giao hàng hoặc chọn địa chỉ có sẵn.',
            'address.regex' => 'Địa chỉ chỉ được chứa chữ, số, dấu cách, dấu phẩy, dấu chấm và dấu gạch ngang.',
            'ward.regex' => 'Xã/Phường chỉ được chứa chữ, số và dấu cách.',
            'district.regex' => 'Quận/Huyện chỉ được chứa chữ, số và dấu cách.',
            'city.regex' => 'Thành phố chỉ được chứa chữ, số và dấu cách.',
            'shipping_address_id.exists' => 'Địa chỉ được chọn không hợp lệ.',
            'coupon_code.max' => 'Mã giảm giá không được vượt quá 50 ký tự.',
        ]);

        $cartItemIds = $request->input('cart_item_ids');
        Log::info('Raw cart_item_ids: ' . var_export($cartItemIds, true));

        if (empty($cartItemIds)) {
            Log::warning('cart_item_ids is empty');
            return redirect()->route('cart.index')->with('warning', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        if (is_string($cartItemIds)) {
            $cartItemIds = array_filter(explode(',', $cartItemIds), function ($id) {
                return is_numeric($id) && intval($id) > 0;
            });
        }

        Log::info('Filtered cart_item_ids: ' . var_export($cartItemIds, true));

        if (empty($cartItemIds)) {
            Log::warning('Filtered cart_item_ids is empty');
            return redirect()->route('cart.index')->with('warning', 'Danh sách sản phẩm không hợp lệ.');
        }

        $cartItems = Cart::with(['productVariant.product'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartItemIds)
            ->get();

        if ($cartItems->isEmpty()) {
            Log::warning('No cart items found for user_id: ' . Auth::id() . ', cart_item_ids: ' . implode(',', $cartItemIds));
            return redirect()->route('cart.index')->with('warning', 'Không tìm thấy sản phẩm để thanh toán.');
        }

        DB::beginTransaction();
        try {
            // Xử lý địa chỉ giao hàng
            if ($request->filled('shipping_address_id')) {
                $shippingAddress = ShippingAddress::where('user_id', Auth::id())
                    ->where('id', $request->shipping_address_id)
                    ->firstOrFail();
            } else {
                $existingAddress = ShippingAddress::where('user_id', Auth::id())
                    ->where('name', $request->name)
                    ->where('phone_number', $request->phone_number)
                    ->where('address', $request->address)
                    ->where('ward', $request->ward)
                    ->where('district', $request->district)
                    ->where('city', $request->city)
                    ->first();

                if ($existingAddress) {
                    $shippingAddress = $existingAddress;
                } else {
                    $shippingAddress = ShippingAddress::create([
                        'user_id' => Auth::id(),
                        'name' => $request->name,
                        'phone_number' => $request->phone_number,
                        'address' => $request->address,
                        'ward' => $request->ward,
                        'district' => $request->district,
                        'city' => $request->city,
                        'is_default' => false,
                    ]);
                }
            }

            // Xử lý mã giảm giá
            $coupon = null;
            $discount = 0;
            $couponId = null;

            if ($request->filled('coupon_code')) {
                $coupon = Coupon::where('code', $request->coupon_code)
                    ->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();

                if ($coupon) {
                    if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
                        throw new \Exception('Mã giảm giá đã đạt giới hạn sử dụng.');
                    }

                    $userUsage = Order::where('user_id', Auth::id())
                        ->where('coupon_id', $coupon->id)
                        ->count();
                    if ($coupon->user_usage_limit !== null && $userUsage >= $coupon->user_usage_limit) {
                        throw new \Exception('Bạn đã sử dụng mã giảm giá này quá số lần cho phép.');
                    }

                    $subtotal = $cartItems->sum(function ($item) {
                        return $item->productVariant->price * $item->quantity;
                    });

                    if ($coupon->min_order_value !== null && $subtotal < $coupon->min_order_value) {
                        throw new \Exception('Tổng giá trị đơn hàng chưa đạt mức tối thiểu ' . number_format($coupon->min_order_value, 0, ',', '.') . ' ₫.');
                    }

                    $isApplicable = false;
                    $applicableCategories = $coupon->applicable_categories ? json_decode($coupon->applicable_categories, true) : [];
                    $applicableProducts = $coupon->applicable_products ? json_decode($coupon->applicable_products, true) : [];

                    if (empty($applicableCategories) && empty($applicableProducts)) {
                        $isApplicable = true;
                    } else {
                        foreach ($cartItems as $item) {
                            $product = $item->productVariant->product;
                            if (
                                (empty($applicableCategories) || in_array($product->category_id, $applicableCategories)) ||
                                (empty($applicableProducts) || in_array($product->id, $applicableProducts))
                            ) {
                                $isApplicable = true;
                                break;
                            }
                        }
                    }

                    if (!$isApplicable) {
                        throw new \Exception('Mã giảm giá không áp dụng cho các sản phẩm trong giỏ hàng.');
                    }

                    $discount = $this->calculateDiscount($coupon, $subtotal, $cartItems);
                    $couponId = $coupon->id;
                } else {
                    throw new \Exception('Mã giảm giá không hợp lệ hoặc đã hết hạn.');
                }
            }

            // Tính tổng tiền
            $subtotal = $cartItems->sum(function ($item) {
                return $item->productVariant->price * $item->quantity;
            });
            $shippingFee = 20000;
            $totalPrice = $subtotal + $shippingFee - $discount;

            // Tạo mã đơn hàng
            $orderCode = 'ORD-' . strtoupper(Str::random(8));

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $orderCode,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_method' => $request->paymentMethod === 'momo' ? 'online' : 'cod',
                'payment_status' => 'pending',
                'note' => $request->note ?? null,
                'shipping_address_id' => $shippingAddress->id,
                'coupon_id' => $couponId,
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'import_price' => $item->productVariant->import_price,
                    'price' => $item->productVariant->price,
                    'discount' => 0, // Có thể áp dụng giảm giá chi tiết nếu cần
                    'subtotal' => $item->productVariant->price * $item->quantity,
                ]);
            }

            // Cập nhật used_count của mã giảm giá
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // Xóa sản phẩm khỏi giỏ hàng nếu chọn COD
            if ($request->paymentMethod === 'cod') {
                Cart::where('user_id', Auth::id())
                    ->whereIn('id', $cartItemIds)
                    ->delete();
            } else {
                session(['pending_cart_item_ids' => $cartItemIds]);
            }

            // Xóa session coupon sau khi đặt hàng
            session()->forget('coupon');

            DB::commit();
            Log::info('Checkout completed successfully', ['order_id' => $order->id]);

            if ($request->paymentMethod === 'momo') {
                session(['pending_order_id' => $order->id]);
                return redirect()->route('pay')->with('success', 'Đơn hàng đã được tạo. Vui lòng thanh toán để hoàn tất.');
            }

            return redirect()->route('account.show')->with('order-success', 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'cart_item_ids' => $cartItemIds
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage())->withInput();
        }
    }
}