@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Chỉnh sửa Voucher  <strong class="text-primary">{{ $coupon->code }}</strong></h3>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-body">
                <!-- Hiển thị thông báo lỗi -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Lỗi nhập liệu:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Hiển thị thông báo thành công (nếu có) -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="code" class="form-label">Mã Voucher <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" maxlength="50" >
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                        <select name="discount_type" id="discount_type" class="form-control @error('discount_type') is-invalid @enderror" >
                            <option value="" disabled {{ old('discount_type', $coupon->discount_type) ? '' : 'selected' }}>Chọn loại</option>
                            <option value="percent" {{ old('discount_type', $coupon->discount_type) == 'percent' ? 'selected' : '' }}>Phần trăm</option>
                            <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Cố định</option>
                        </select>
                        @error('discount_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Giá trị giảm <span class="text-danger">*</span></label>
                        <input type="number" name="discount_value" id="discount_value" class="form-control @error('discount_value') is-invalid @enderror" step="0.01" min="0" value="{{ old('discount_value', $coupon->discount_value) }}" >
                        @error('discount_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="min_order_value" class="form-label">Đơn hàng tối thiểu</label>
                        <input type="number" name="min_order_value" id="min_order_value" class="form-control @error('min_order_value') is-invalid @enderror" step="0.01" min="0" value="{{ old('min_order_value', $coupon->min_order_value) }}">
                        @error('min_order_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="max_discount" class="form-label">Giảm tối đa</label>
                        <input type="number" name="max_discount" id="max_discount" class="form-control @error('max_discount') is-invalid @enderror" step="0.01" min="0" value="{{ old('max_discount', $coupon->max_discount) }}">
                        @error('max_discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $coupon->start_date->format('Y-m-d')) }}" >
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $coupon->end_date->format('Y-m-d')) }}" >
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="usage_limit" class="form-label">Giới hạn sử dụng</label>
                        <input type="number" name="usage_limit" id="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" min="1" value="{{ old('usage_limit', $coupon->usage_limit) }}">
                        @error('usage_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="user_usage_limit" class="form-label">Giới hạn mỗi người</label>
                        <input type="number" name="user_usage_limit" id="user_usage_limit" class="form-control @error('user_usage_limit') is-invalid @enderror" min="1" value="{{ old('user_usage_limit', $coupon->user_usage_limit) }}">
                        @error('user_usage_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" >
                            <option value="" disabled {{ old('status', $coupon->status) ? '' : 'selected' }}>Chọn trạng thái</option>
                            <option value="active" {{ old('status', $coupon->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $coupon->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Cập nhật Voucher</button>
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection