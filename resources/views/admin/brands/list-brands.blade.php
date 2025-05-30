@extends('admin.layouts.AdminLayouts')
@section('title-page')
<h3>Danh sách Thương hiệu</h3>
@endsection
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row g-4 mb-4">
            <!-- Cột trái: Danh sách Brands với bảng và paginate -->
            <div class="col-md-8">
                {{-- Phần tìm kiếm --}}
                <div class="card-header bg-info text-white fw-bold">
                    <div class="row align-items-center">
                        <!-- Tìm kiếm -->
                        <div class="col-md-10">
                        <form class="d-flex" method="GET" action="">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Tìm kiếm Brand...">
                            <button class="btn btn-light text-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                         </form>
                        </div>

                        <!-- Nút thêm -->
                        <div class="col-md-2 text-end">
                            <button class="btn btn-success">
                              <a href="{{ route('brands.create') }}" class="text-white"><i class="bi bi-plus-circle me-1"></i> Thêm</a>
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Kết thúc tìm kiếm --}}

                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên thương hiệu</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($brands->count())
                            @foreach($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                      <td>
                                        <img src="{{ $brand->image ? asset('storage/' . $brand->image) : asset('images/placeholder.png') }}"
                                            alt="{{ $brand->name }}"
                                            style="width: 80px; height: auto; object-fit: cover;">
                                    </td>
                                    {{-- nếu status==active thì màu xanh, nếu status==inactive thì màu đỏ --}}
                                    <td>
                                        <span class="badge {{ $brand->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $brand->status }}
                                        </span>
                                    </td>
                                   
                                    <td>
                                      <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-sm btn-primary me-1">
                                    <i class="bi bi-info-circle"></i> Chi tiết
                                </a>
                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Xoá
                                    </button>
                                </form>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Chưa có dữ liệu</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{-- Phân trang --}}
                <div class="d-flex justify-content-center">
                    {{ $brands->links() }}
                </div>
            </div>
            <!-- Kết thúc cột trái -->

            <!-- Cột phải: TOP Nhãn hàng bán chạy -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header mb-2">
                        <strong>
                            <h3 class="card-title">TOP Nhãn hàng bán chạy</h3>
                        </strong>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body p-0">
                        <div class="row text-center g-2 mb-2">
                            <!-- Lặp qua mảng topBrands -->
                            @foreach($topBrands as $brand)
                                <div class="col-3 d-flex flex-column align-items-center">
                                    <!-- Vì bảng brands không có hình ảnh, nên ta sử dụng ảnh placeholder (đặt tại public/images/placeholder.png) -->
                                    <img class="img-fluid rounded-circle mb-1"
                                   src="{{ $brand->image ? asset('storage/' . $brand->image) : asset('images/placeholder.png') }}"
                                       alt="{{ $brand->name }}"
                                    style="width: 60px; height: 60px; object-fit: cover;">

                                    <a class="fw-semibold text-secondary text-center text-truncate d-block w-100"
                                       href="#"
                                       title="{{ $brand->name }}"
                                       style="font-size: 0.85rem;">
                                        {{ $brand->name }}<br>
                                        ({{ $brand->total_sold }})
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- Kết thúc cột phải -->
        </div>
    </div>
</div>
@endsection
