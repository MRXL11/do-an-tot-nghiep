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
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thanh toán.'
            ], 401);
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
            'cart_item_ids' => 'required|string',
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
            'cart_item_ids.required' => 'Danh sách sản phẩm không hợp lệ.',
        ]);

        $cartItemIds = array_filter(explode(',', $request->input('cart_item_ids')), function ($id) {
            return is_numeric($id) && intval($id) > 0;
        });

        if (empty($cartItemIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Danh sách sản phẩm không hợp lệ.'
            ], 422);
        }

        $cartItems = Cart::with(['productVariant.product'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartItemIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm để thanh toán.'
            ], 422);
        }

        // Kiểm tra sản phẩm bị khóa
        foreach ($cartItems as $item) {
            $isLocked = OrderDetail::where('product_variant_id', $item->product_variant_id)
                ->whereHas('order', function ($query) {
                    $query->where('user_id', Auth::id())
                        ->whereIn('payment_method', ['online', 'momo'])
                        ->whereIn('payment_status', ['pending', 'failed']);
                })->exists();

            if ($isLocked) {
                return response()->json([
                    'success' => false,
                    'message' => 'Một số sản phẩm trong giỏ hàng đang bị khóa do đơn hàng chưa thanh toán.'
                ], 403);
            }

            if ($item->productVariant->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => "Sản phẩm {$item->productVariant->product->name} đã ngừng bán."
                ], 400);
            }

            if ($item->productVariant->stock_quantity < $item->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Sản phẩm {$item->productVariant->product->name} không đủ hàng trong kho."
                ], 400);
            }
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
                'payment_method' => $request->paymentMethod === 'card' ? 'online' : ($request->paymentMethod === 'momo' ? 'online' : 'cod'),
                'payment_status' => 'pending',
                'note' => $request->note ?? null,
                'shipping_address_id' => $shippingAddress->id,
                'coupon_id' => $couponId,
                'vnp_txn_ref' => $request->paymentMethod === 'card' ? time() . Str::random(4) : null,
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'import_price' => $item->productVariant->import_price,
                    'price' => $item->productVariant->price,
                    'discount' => 0,
                    'subtotal' => $item->productVariant->price * $item->quantity,
                ]);
            }

            // Cập nhật used_count của mã giảm giá
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // Xử lý giỏ hàng
            if ($request->paymentMethod === 'cod') {
                // Trừ số lượng sản phẩm trong kho và xóa giỏ hàng
                foreach ($cartItems as $item) {
                    $item->productVariant->decrement('stock_quantity', $item->quantity);
                }
                Cart::where('user_id', Auth::id())
                    ->whereIn('id', $cartItemIds)
                    ->delete();
            } else {
                // Lưu thông tin vào session để xử lý sau khi thanh toán online
                session(['pending_cart_item_ids' => $cartItemIds]);
                session(['pending_order_id' => $order->id]);
            }

            // Tạo URL thanh toán VNPay
            if ($request->paymentMethod === 'card') {
                $vnp_TmnCode = env('VNPAY_TMN_CODE', 'WOQ9FKH5');
                $vnp_HashSecret = env('VNPAY_HASH_SECRET', '8LFGJRBPXUPDP2M2EP394Y12EO1OD4TM');
                $vnp_Url = env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
                $vnp_Returnurl = env('VNPAY_RETURN_URL', route('vnpay.return'));

                $vnp_TxnRef = $order->vnp_txn_ref;
                $vnp_OrderInfo = "Thanh toan don hang #" . $order->order_code;
                $vnp_OrderType = "billpayment";
                $vnp_Amount = $totalPrice * 100; // VND x 100
                $vnp_Locale = "vn";
                $vnp_BankCode = "NCB";
                $vnp_IpAddr = $request->ip();

                $inputData = [
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_Version" => "2.1.0",
                ];

                if (!empty($vnp_BankCode)) {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

                ksort($inputData);
                $hashData = "";
                foreach ($inputData as $key => $value) {
                    if ($key !== 'vnp_SecureHash') {
                        $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
                    }
                }
                $hashData = rtrim($hashData, '&');
                $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

                $query = http_build_query($inputData) . '&vnp_SecureHash=' . $vnp_SecureHash;
                $vnpayUrl = $vnp_Url . '?' . $query;
            }

            // Xóa session coupon sau khi đặt hàng
            session()->forget('coupon');

            DB::commit();
            Log::info('Checkout completed successfully', ['order_id' => $order->id]);

            if ($request->paymentMethod === 'card') {
                return response()->json([
                    'success' => true,
                    'vnpay_url' => $vnpayUrl,
                    'message' => 'Đang chuyển hướng đến cổng thanh toán VNPay.'
                ]);
            } elseif ($request->paymentMethod === 'momo') {
                session(['pending_order_id' => $order->id]);
                return response()->json([
                    'success' => true,
                    'redirect' => route('pay'),
                    'message' => 'Đơn hàng đã được tạo. Vui lòng thanh toán để hoàn tất.'
                ]);
            } else {
                session()->flash('order_success', 'Đơn hàng đã được tạo thành công!');
                return response()->json([
                    'success' => true,
                    'redirect' => route('account.show'),
                    'message' => 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'cart_item_ids' => $cartItemIds
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage()
            ], 422);
        }
    }

    public function retryPayment(Request $request, Order $order)
    {
        if (
            in_array($order->payment_method, ['online', 'bank_transfer']) &&
            in_array($order->payment_status, ['pending', 'failed']) &&
            in_array($order->status, ['pending', 'cancelled'])
        ) {
            // Tạo mã giao dịch mới
            $order->update([
                'vnp_txn_ref' => 'RETRY' . time() . $order->id,
            ]);

            session(['pending_order_id' => $order->id]);

            // Cấu hình VNPay
            $vnp_TmnCode = env('VNPAY_TMN_CODE', 'WOQ9FKH5');
            $vnp_HashSecret = env('VNPAY_HASH_SECRET', '8LFGJRBPXUPDP2M2EP394Y12EO1OD4TM');
            $vnp_Url        = env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html');
            $vnp_Returnurl  = env('VNPAY_RETURN_URL', route('vnpay.return'));

            $inputData = [
                "vnp_Version"    => "2.1.0",
                "vnp_TmnCode"    => $vnp_TmnCode,
                "vnp_Amount"     => $order->total_price * 100,
                "vnp_Command"    => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode"   => "VND",
                "vnp_IpAddr"     => $request->ip(),
                "vnp_Locale"     => "vn",
                "vnp_OrderInfo"  => "Thanh toán lại đơn hàng #" . $order->order_code,
                "vnp_OrderType"  => "billpayment",
                "vnp_ReturnUrl"  => $vnp_Returnurl,
                "vnp_TxnRef"     => $order->vnp_txn_ref,
                "vnp_BankCode"   => "NCB",
            ];

            // Bước 1: Sắp xếp dữ liệu theo key
            ksort($inputData);

            // Bước 2: Tạo chuỗi hash đúng định dạng
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($key !== 'vnp_SecureHash') {
                    $hashData .= urlencode($key) . '=' . urlencode($value) . '&';
                }
            }
            $hashData = rtrim($hashData, '&');

            // Bước 3: Tạo secure hash
            $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            // Bước 4: Gắn vào URL
            $inputData['vnp_SecureHash'] = $vnp_SecureHash;
            $vnpayUrl = $vnp_Url . '?' . http_build_query($inputData);

            Log::info('VNPay hashData', ['hashData' => $hashData]);
            Log::info('VNPay secureHash', ['vnp_SecureHash' => $vnp_SecureHash]);
            Log::info('VNPay URL', ['url' => $vnpayUrl]);

            return redirect($vnpayUrl);
        }

        return redirect()->back()->with('error', 'Không thể thanh toán lại đơn hàng này.');
    }
}
