@extends('admin.layouts.AdminLayouts')

@section('title')
    <title>Quản lý sản phẩm</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <!-- Form tìm kiếm -->
                    <form class="row gx-2 align-items-center mb-2" action="{{ route('products') }}" method="GET">
                        <!-- Ô tìm kiếm -->
                        <div class="col-auto">
                            <div class="input-group">
                                <span class="input-group-text bg-light" id="search-icon">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control form-group-lg" placeholder="Tìm kiếm sản phẩm..."
                                    aria-label="Tìm kiếm" aria-describedby="search-icon" name="q"
                                    value="{{ request('q') }}">
                            </div>
                        </div>

                        <!-- Select danh mục -->
                        <div class="col-auto">
                            <select class="form-select" name="category">
                                <option value="">--Danh mục--</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select thương hiệu -->
                        <div class="col-auto">
                            <select class="form-select" name="brand">
                                <option value="">--Thương hiệu--</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Select trạng thái -->
                        <div class="col-auto">
                            <select class="form-select" name="status">
                                <option value="">-- Trạng thái --</option>
                                @foreach ($statuses as $key => $status)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nút submit -->
                        <div class="col-auto">
                            <button class="btn btn-primary" type="submit">
                                Tìm kiếm
                            </button>
                        </div>
                    </form>

                    <!-- Thông báo không tìm thấy -->
                    @if ($noResults)
                        <div class="alert alert-warning" role="alert">
                            Không tìm thấy sản phẩm nào khớp với tiêu chí tìm kiếm.
                        </div>
                    @else
                        <!-- Bảng sản phẩm -->
                        <div class="table-responsive-sm">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Tên sản phẩm</th>
                                        <th class="text-center">Hình ảnh</th>
                                        <th class="text-center">SKU</th>
                                        <th class="text-center">Thương hiệu</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="text-center">{{ $product->id }}</td>
                                            <td class="text-center text-truncate">
                                                {{ Str::limit($product->name, 20, '...') }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('dist/assets/img/prod-1.jpg') }}" alt="Thumbnail"
                                                    class="img-fluid" style="max-width: 50px; height: auto;" />
                                            </td>
                                            <td class="text-center">{{ $product->sku }}</td>
                                            <td class="text-center">{{ $product->brand ? $product->brand->name : 'N/A' }}
                                            </td>
                                            <td class="text-center">{{ $product->status }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-primary">Chi tiết</button>
                                                <button type="button" class="btn btn-sm btn-warning">Sửa</button>
                                                <button type="button" class="btn btn-sm btn-danger">Xóa</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        {{ $products->links() }}
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-sm btn-block btn-success mb-2">Thêm sản phẩm</button><br>
                            <h3 class="card-title">Các sản phẩm đã thêm gần đây</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="px-2">
                                <div class="d-flex border-top py-2 px-1">
                                    <div class="col-2">
                                        <img src="../../dist/assets/img/default-150x150.png" alt="Product Image"
                                            class="img-size-50" />
                                    </div>
                                    <div class="col-10">
                                        <a href="javascript:void(0)" class="fw-bold">
                                            Samsung TV
                                            <span class="badge text-bg-warning float-end"> $1800 </span>
                                        </a>
                                        <div class="text-truncate">Samsung 32" 1080p 60Hz LED Smart HDTV.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
