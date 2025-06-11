@extends('admin.layouts.AdminLayouts')
@section('title-page')
    <h3>Danh sách Coupons</h3>
@endsection
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card shadow">
            <!-- Phần tìm kiếm -->
            <div class="card-header text-white fw-bold">
             <div class="row align-items-center mb-2">
             <div class="col-md-8">
            <form class="d-flex gap-2" method="GET" action="{{ route('admin.coupons.index') }}">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm mã giảm giá..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit()">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> 
                </button>
                {{-- tìm kiếm thông thường --}}
                <select name="status" class="form-select w-25 text-center" onchange="this.form.submit()">
                    <option value="" {{ !request('status') ? 'selected' : '' }}>Trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </form>
            </div>
            {{-- lọc trạng thái theo seclect --}}
        <div class="col-md-2 text-end">
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-success form-control">
                <i class="bi bi-plus-circle me-1"></i> Thêm Coupon
            </a>
        </div>
        {{-- router thêm coupon --}}
        <div class="col-md-2 text-end">
            <a href="{{ route('admin.admin.coupons.trashed') }}" class="btn btn-outline-danger form-control">
                <i class="bi bi-trash me-1"></i> Thùng rác
            </a>
        </div>
        {{-- thùng rác --}}
    </div>

            </div>
            <div class="card-body p-0">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                {{-- kết thúc thông báo --}}
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
                                <td>
                                    @if ($coupon->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>

                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Coupon này sau khi xóa sẽ chuyển vào thùng rác?')">
                                            Chuyển vào <i class="bi bi-trash"></i> 
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