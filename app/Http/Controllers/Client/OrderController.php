<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ]
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            \Log::error('CURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function createOrderCancelNotificationToAdmin(Request $request, $id, string $title = 'Cập nhật đơn hàng')
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->with('cancel-request-error', 'Đơn hàng không tồn tại.');
        }

        // Chỉ cho phép huỷ nếu đơn chưa xử lý xong
        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('cancel-request-error', 'Đơn hàng này không thể huỷ nữa.');
        }

        // Kiểm tra đã gửi yêu cầu chưa
        if ($order->cancellation_requested) {
            return redirect()->back()->with('cancel-request-error', 'Bạn đã gửi yêu cầu huỷ đơn hàng này trước đó. Vui lòng chờ admin xử lý.');
        }

        // Lấy lý do từ form
        $reason = $request->cancel_reason;
        if (empty($reason)) {
            return redirect()->back()->with('cancel-request-error', 'Vui lòng nhập lý do huỷ đơn hàng.');
        }

        try {
            // Cập nhật đơn hàng: đánh dấu đã gửi yêu cầu + lưu lý do
            $order->cancel_reason = $reason;
            $order->cancellation_requested = true;
            $order->cancel_confirmed = false; // chưa được duyệt
            if (
                !empty($order->vnp_txn_ref) &&
                $order->payment_method === 'online' &&
                $order->payment_status === 'pending' &&
                $order->status === 'pending'
            ) {
                // Người dùng hủy khi chưa thanh toán => coi như không mua nữa
                $order->payment_status = 'failed';
            }

            $order->save();

            // Gửi thông báo đến admin
            $admins = User::where('role_id', 1)->get();
            if ($admins->isEmpty()) {
                return redirect()->back()->with('cancel-request-error', 'Không có admin nào để gửi thông báo.');
            }

            $message = "Người dùng {$order->user->name} yêu cầu huỷ đơn hàng #{$order->order_code} với lý do: {$order->cancel_reason}. Vui lòng kiểm tra và xử lý.";

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'   => $admin->id,
                    'title'     => $title,
                    'message'   => $message,
                    'type'      => 'order',
                    'is_read'   => false,
                    'order_id'  => $order->id,
                    'created_at' => now(),
                ]);
            }

            return redirect()->back()->with('cancel-request-success', 'Đã gửi yêu cầu huỷ đơn hàng thành công. Vui lòng chờ admin xử lý.');
        } catch (\Exception $e) {
            Log::error('Lỗi tạo yêu cầu huỷ đơn hàng: ' . $e->getMessage());
            return redirect()->back()->with('cancel-request-error', 'Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại.');
        }
    }

    public function pay(Request $request)
    {
        $orderId = session('pending_order_id') ?? $request->input('order_id');
        if (!$orderId) {
            Log::warning('No pending_order_id found in session');
            return redirect()->route('cart.index')->with('error', 'Không tìm thấy đơn hàng để thanh toán.');
        }

        $order = Order::with(['orderDetails.productVariant.product', 'shippingAddress'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('payment_method', 'online')
            ->first();

        if (!$order) {
            Log::warning('Order not found or invalid', [
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'payment_method' => $order ? $order->payment_method : 'not_found'
            ]);
            return redirect()->route('cart.index')->with('error', 'Đơn hàng không hợp lệ hoặc không tồn tại.');
        }

        $subtotal = $order->orderDetails->sum(function ($detail) {
            return $detail->price * $detail->quantity;
        });
        $shippingFee = 20000;
        $total = $order->total_price;

        $cartItems = Cart::where('user_id', Auth::id())->get();
        \Log::info('Cart items after redirect to pay: ' . $cartItems->toJson());
        \Log::info('Order details for pay', [
            'order_id' => $orderId,
            'total_price' => $order->total_price,
            'calculated_total' => $total
        ]);

        return view('client.pages.pay', [
            'order' => $order,
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee,
            'total' => $total,
        ]);
    }

    public function momo_payment(Request $request)
    {
        $orderId = session('pending_order_id') ?? $request->input('order_id');
        if (!$orderId) {
            \Log::warning('No pending_order_id found in session');
            return redirect()->route('cart.index')->with('error', 'Không tìm thấy đơn hàng để thanh toán.');
        }

        $order = Order::findOrFail($orderId);
        if ($order->user_id !== Auth::id() || $order->payment_method !== 'online') {
            \Log::warning('Invalid order or payment method', [
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'payment_method' => $order->payment_method
            ]);
            return redirect()->route('cart.index')->with('error', 'Đơn hàng không hợp lệ.');
        }

        // Validate total_momo
        $request->validate([
            'total_momo' => 'required|numeric|min:1000', // Momo yêu cầu tối thiểu 1000 VND
        ], [
            'total_momo.required' => 'Số tiền thanh toán không được để trống.',
            'total_momo.numeric' => 'Số tiền thanh toán phải là số.',
            'total_momo.min' => 'Số tiền thanh toán phải lớn hơn hoặc bằng 1000 VND.',
        ]);

        $amount = (int) $request->input('total_momo'); // Ép kiểu thành số nguyên
        \Log::info('Momo payment amount check', [
            'total_momo' => $request->input('total_momo'),
            'amount' => $amount,
            'order_total_price' => $order->total_price
        ]);

        if (abs($amount - (int)$order->total_price) > 0) {
            \Log::warning('Momo payment amount mismatch', [
                'order_id' => $orderId,
                'total_momo' => $amount,
                'order_total_price' => $order->total_price
            ]);
            return redirect()->route('cart.index')->with('error', 'Số tiền thanh toán không khớp với đơn hàng.');
        }

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán đơn hàng #{$order->order_code}";
        $orderIdMomo = $order->order_code . '-' . time();
        $requestId = $order->order_code . '-' . time() . '-req';
        $redirectUrl = url('/account');
        $ipnUrl = url('/momo_callback');
        $extraData = "";
        $requestType = 'payWithATM';

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderIdMomo&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => 'Test',
            'storeId' => 'MomoTestStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderIdMomo,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        try {
            \Log::info('Momo request data', $data);
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);

            \Log::info('Momo payment response', ['response' => $jsonResult]);

            if (isset($jsonResult['payUrl']) && $jsonResult['resultCode'] == 0) {
                // Cập nhật trạng thái đơn hàng
                $order->update([
                    'payment_status' => 'completed',
                    'status' => 'processing',
                ]);

                // Xóa các sản phẩm được chọn trong giỏ hàng
                $cartItemIds = session('pending_cart_item_ids', []);
                if (!empty($cartItemIds)) {
                    \Log::info('Deleting cart items for Momo payment', [
                        'user_id' => Auth::id(),
                        'cart_item_ids' => $cartItemIds
                    ]);
                    Cart::where('user_id', Auth::id())
                        ->whereIn('id', $cartItemIds)
                        ->delete();

                    // Xóa session
                    session()->forget(['pending_cart_item_ids', 'pending_order_id']);
                } else {
                    \Log::warning('No cart_item_ids found in session for deletion', ['order_id' => $orderId]);
                }

                \Log::info('Momo payment successful, cart cleared', ['order_id' => $orderId, 'payUrl' => $jsonResult['payUrl']]);
                return redirect($jsonResult['payUrl']);
            }

            \Log::error('Momo payment initiation failed', ['response' => $jsonResult]);
            return redirect()->route('cart.index')->with('error', 'Không thể khởi tạo thanh toán Momo: ' . ($jsonResult['message'] ?? 'Lỗi không xác định'));
        } catch (\Exception $e) {
            \Log::error('Momo payment error: ' . $e->getMessage(), ['order_id' => $orderId]);
            return redirect()->route('cart.index')->with('error', 'Lỗi khi xử lý thanh toán Momo: ' . $e->getMessage());
        }
    }

    public function momoCallback(Request $request)
    {
        $orderId = $request->input('orderId');
        if (!$orderId) {
            \Log::warning('No orderId in Momo callback', ['request' => $request->all()]);
            return response()->json(['error' => 'Invalid order']);
        }

        // Tìm đơn hàng dựa trên orderId (loại bỏ phần timestamp)
        $orderCode = explode('-', $orderId)[0];
        $order = Order::where('order_code', $orderCode)->first();

        if (!$order) {
            \Log::warning('Order not found in Momo callback', ['order_id' => $orderId]);
            return response()->json(['error' => 'Order not found']);
        }

        $resultCode = $request->input('resultCode', 1);
        if ($resultCode == 0) {
            // Cập nhật trạng thái đơn hàng
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing',
            ]);

            // Xóa giỏ hàng (nếu chưa xóa)
            $cartItemIds = session('pending_cart_item_ids', []);
            if (!empty($cartItemIds)) {
                \Log::info('Deleting cart items for Momo callback', [
                    'user_id' => $order->user_id,
                    'cart_item_ids' => $cartItemIds
                ]);
                Cart::where('user_id', $order->user_id)
                    ->whereIn('id', $cartItemIds)
                    ->delete();
                session()->forget(['pending_cart_item_ids', 'pending_order_id']);
            }

            \Log::info('Momo payment confirmed via callback', ['order_id' => $orderId]);
            return response()->json(['message' => 'Payment confirmed']);
        }

        \Log::warning('Momo payment failed via callback', ['order_id' => $orderId, 'result' => $request->all()]);
        return response()->json(['error' => 'Payment failed']);
    }

    public function received($id)
    {
        $user = Auth::user();
        $order = Order::find($id);

        if (!$order || $order->user_id !== $user->id) {
            return redirect()->back()->with('received-error', 'Bạn không có quyền xác nhận đơn hàng này.');
        }

        if ($order->status === 'completed') {
            return redirect()->back()->with('received-info', 'Đơn hàng này đã được xác nhận trước đó.');
        }

        $order->status = 'completed';
        $order->payment_status = 'completed';
        // $order->confirmed_at = now(); // nếu có cột
        $order->save();

        return redirect()->back()->with(
            'received-success',
            "Cảm ơn quý khách! Đơn hàng #{$order->order_code} đã được xác nhận là đã nhận vào lúc " . now()->format('H:i d/m/Y')
        );
    }
    /**
     * Trang thành công
     */
    public function success(Order $order)
    {
        return view('client.pages.order-success', ['order' => $order]);
    }

    /**
     * Trang thất bại
     */
    public function failed()
    {
        $error = session('payment_error', 'Thanh toán không thành công. Vui lòng thử lại.');
        return view('client.pages.order-failed', ['error' => $error]);
    }
}
