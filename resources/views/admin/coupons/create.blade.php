@extends('admin.layouts.AdminLayouts')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header text-white fw-bold">
                <h4>Thêm Voucher Mới</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="code" class="form-label">Mã Voucher</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Loại giảm giá</label>
                        <select name="discount_type" id="discount_type" class="form-control" required>
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần trăm</option>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Cố định</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Giá trị giảm</label>
                        <input type="number" name="discount_value" id="discount_value" class="form-control" step="0.01" value="{{ old('discount_value') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="min_order_value" class="form-label">Đơn hàng tối thiểu</label>
                        <input type="number" name="min_order_value" id="min_order_value" class="form-control" step="0.01" value="{{ old('min_order_value') }}">
                    </div>
                    <div class="mb-3">
                        <label for="max_discount" class="form-label">Giảm tối đa</label>
                        <input type="number" name="max_discount" id="max_discount" class="form-control" step="0.01" value="{{ old('max_discount') }}">
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Ngày kết thúc</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="usage_limit" class="form-label">Giới hạn sử dụng</label>
                        <input type="number" name="usage_limit" id="usage_limit" class="form-control" value="{{ old('usage_limit') }}">
                    </div>
                    <div class="mb-3">
                        <label for="user_usage_limit" class="form-label">Giới hạn mỗi người</label>
                        <input type="number" name="user_usage_limit" id="user_usage_limit" class="form-control" value="{{ old('user_usage_limit') }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Thêm Voucher</button>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection