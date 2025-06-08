@extends('admin.layouts.AdminLayouts')

@section('title-page', 'Thêm sản phẩm')

@section('content')
    <div class="container-fluid">

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @php
                        $uniqueErrors = array_unique($errors->all());
                    @endphp
                    @foreach ($uniqueErrors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form thêm sản phẩm --}}
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3 align-items-center mb-3">
                <!-- Thêm ảnh -->
                <div class="col-md-5 text-center">
                    <img id="preview_thumbnail" src="https://via.placeholder.com/400x300?text=Preview"
                        class="img-fluid rounded mb-2" style="max-height: 400px; object-fit: cover; cursor: pointer;"
                        alt="Ảnh sản phẩm" onclick="document.querySelector('input[name=thumbnail]').click()">
                    <div class="mt-3">
                        <label for="thumbnail" class="form-label d-none" id="label_thumbnail">Chọn ảnh</label>
                        <input type="file" id="thumbnail" name="thumbnail" class="form-control d-none" accept="image/*"
                            onchange="previewThumbnail(this)">
                    </div>
                    @error('thumbnail')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Thêm thông tin sản phẩm -->
                <div class="col-md-7">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select name="category_id" class="form-control" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="brand_id" class="form-label">Thương hiệu</label>
                            <select name="brand_id" class="form-control" id="brand_id">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" class="form-control" id="status">
                                <option value="active">Kích hoạt</option>
                                <option value="inactive">Tạm ẩn</option>
                                <option value="out_of_stock">Hết hàng</option>
                            </select>
                            @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="short_description" class="form-label">Mô tả ngắn</label>
                            <input type="text" name="short_description" class="form-control" id="short_description"
                                value="{{ old('short_description') }}">
                            @error('short_description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            {{-- Thông tin biến thể  --}}
            <h4>Thông tin biến thể</h4>
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Danh sách màu (ngăn cách bằng dấu phẩy)</label>
                            <input type="text" id="colors" name='colors' class="form-control"
                                placeholder="Đỏ,Trắng,Xanh" value="{{ old('colors') }}">
                        </div>

                        <div class="col-md-6">
                            <label>Danh sách size (ngăn cách bằng dấu phẩy)</label>
                            <input type="text" id="sizes" name='sizes' class="form-control" placeholder="S,M,L,XL"
                                value="{{ old('sizes') }}">
                        </div>

                        <div class="col-md-6">
                            <label>Giá mặc định</label>
                            <input type="number" id="default_price" name='default_price' class="form-control"
                                step="any" value="{{ old('default_price') }}">
                        </div>

                        <div class="col-md-6">
                            <label>Số lượng mặc định</label>
                            <input type="number" id="default_quantity" name='default_quantity' class="form-control"
                                value="{{ old('default_quantity') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút tạo biến thể (nhấn sau khi đã nhập tất cả thông tin hợp lệ cho biến thể) --}}
            <button type="button" class="btn btn-secondary mb-3" onclick="generateVariants()">Tạo biến thể</button>

            {{-- Danh sách biến thể sẽ được hiển thị ở đây --}}
            <ul id="variantList"></ul>

            {{-- Input ẩn để gửi dữ liệu khi submit (dữ liệu được xử lý ở bên script) --}}
            <input type="hidden" name="variants" id="variants">

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                </div>
            </div>
        </form>


    </div>
@endsection
