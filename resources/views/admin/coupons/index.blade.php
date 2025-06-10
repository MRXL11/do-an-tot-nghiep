@extends('admin.layouts.AdminLayouts')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card shadow">
            <!-- Phần tìm kiếm -->
            <div class="card-header text-white fw-bold">
                <div class="row align-items-center">
                    <div class="col-md-10">
                        <form class="d-flex" method="GET" action="{{ route('admin.coupons.index') }}">
                            <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm mã giảm giá..." value="{{ request('search') }}">
                            <button class="btn btn-light text-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Thêm Coupon
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <table class="table table-hover table-bordered align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Mã Coupon</th>
                            <th>Giảm giá</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái</th>
                            <th width="237">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $stt = ($coupons->currentPage() - 1) * $coupons->perPage() + 1; @endphp
                        @forelse ($coupons as $coupon)
                            <tr>
                                <td>{{ $stt++ }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>
                                    @if ($coupon->discount_type == 'percent')
                                        {{ $coupon->discount_value }}%
                                    @else
                                        {{ number_format($coupon->discount_value, 2) }} VNĐ
                                    @endif
                                </td>
                                <td>{{ $coupon->start_date->format('Y-m-d') }}</td>
                                <td>{{ $coupon->end_date->format('Y-m-d') }}</td>
                                <td>{!! $coupon->status_badge !!}</td>
                                <td>
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>

                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa coupon này?')">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Không có coupon nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $coupons->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection