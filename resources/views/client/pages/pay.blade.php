@extends('client.pages.page-layout')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-4">

                    {{-- BÊN TRÁI: Địa chỉ & Sản phẩm --}}
                    <div class="col-md-6">

                        {{-- 🏠 Địa chỉ giao hàng --}}
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3">Địa chỉ nhận hàng</h5>
                                <p><strong>Người nhận:</strong> Nguyễn Văn A</p>
                                <p><strong>Điện thoại:</strong> 0909 123 456</p>
                                <p><strong>Địa chỉ:</strong> 123 Đường ABC, Phường DEF, Quận GHI, TP. HCM</p>
                                {{-- ✅ Thay bằng biến động nếu cần --}}
                            </div>
                        </div>

                        {{-- 📦 Danh sách sản phẩm --}}
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3">Sản phẩm trong đơn</h5>
                                <ul class="list-group">
                                    {{-- 🧥 Sản phẩm 1 --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Áo thun nam cổ tròn</strong> <span>x2</span><br>
                                            <small>Size: M, Màu: Đen</small>
                                        </div>
                                        <strong>200.000 ₫</strong>
                                    </li>

                                    {{-- 👖 Sản phẩm 2 --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Quần short kaki</strong> <span>x1</span><br>
                                            <small>Size: L, Màu: Kem</small>
                                        </div>
                                        <strong>150.000 ₫</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- 🔄 Trạng thái thanh toán --}}
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3">Trạng thái thanh toán</h5>
                                <p class="mb-2">⏳ Đang chờ thanh toán từ Momo...</p>
                                <p class="text-muted small">
                                    Sau khi bạn hoàn tất thanh toán, hệ thống sẽ tự động xác nhận đơn hàng.<br>
                                    Nếu gặp sự cố, vui lòng liên hệ CSKH.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- BÊN PHẢI: Mã QR & Trạng thái --}}
                    <div class="col-md-6">

                        {{-- 🔺 Tiêu đề --}}
                        <h4 class="mb-4 text-center">
                            <i class="bi bi-phone-fill me-2 text-danger"></i>Quét mã QR Momo để thanh toán
                        </h4>

                        {{-- 🔳 Mã QR thanh toán --}}
                        <div class="card mb-4 shadow-sm text-center p-4">
                            <h5 class="mb-3">Số tiền cần thanh toán:</h5>
                            <h3 class="text-danger fw-bold">100.000 ₫</h3>
                            <p class="text-muted mb-3">Vui lòng quét mã QR bên dưới bằng ứng dụng Momo</p>

                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=Thanh+toan+Momo+Demo"
                                alt="QR Momo" class="img-fluid rounded mx-auto d-block shadow" style="max-height: 250px;">

                            <div class="alert alert-warning mt-3">
                                ⚠️ Mã QR có hiệu lực trong vòng 15 phút. Vui lòng không đóng trang khi chưa thanh toán.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
