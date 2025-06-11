
@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Coupon đã xóa</h3>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Form tìm kiếm -->
    <div class="row align-items-center mb-4">
        <div class="col-md-10">
            <form class="d-flex gap-2" method="GET" action="">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm mã giảm giá..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit()">
            </form>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    <!-- Thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Bảng danh sách coupon đã xóa -->
    <div class="card shadow">
        <div class="card-body">
            @if ($coupons->isEmpty())
                <p class="text-muted">Không tìm thấy coupon nào trong thùng rác.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0 text-center">
                        <thead>
                            <tr>
                                <th>Mã Coupon</th>
                                <th>Loại giảm giá</th>
                                <th>Giá trị</th>
                                <th>Ngày xóa</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->discount_type == 'percent' ? 'Phần trăm' : 'Cố định' }}</td>
                                    <td>{{ number_format($coupon->discount_value, 2) }}</td>
                                    <td>{{ $coupon->deleted_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if ($coupon->status == 'active')
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Ngừng hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.admin.coupons.restore', $coupon->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn khôi phục coupon này?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                                            </button>
                                        </form>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Phân trang -->
                {{ $coupons->appends(request()->query())->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
</div>
@endsection