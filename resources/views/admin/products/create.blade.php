@extends('admin.layouts.AdminLayouts')

@section('title', 'Thêm sản phẩm')

@section('content')
    <div class="container-fluid">
        <h2>Thêm sản phẩm</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3 align-items-center mb-3">
                <!-- Ảnh bên trái -->
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

                <!-- Thông tin sản phẩm bên phải -->
                <div class="col-md-7">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" id="name">
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
                            <input type="text" name="short_description" class="form-control" id="short_description">
                            @error('short_description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h4>Thông tin biến thể (tuỳ chọn)</h4>
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Danh sách màu (ngăn cách bằng dấu phẩy)</label>
                            <input type="text" id="colors" class="form-control" placeholder="Đỏ,Trắng,Xanh">
                        </div>

                        <div class="col-md-6">
                            <label>Danh sách size (ngăn cách bằng dấu phẩy)</label>
                            <input type="text" id="sizes" class="form-control" placeholder="S,M,L,XL">
                        </div>

                        <div class="col-md-6">
                            <label>Giá mặc định</label>
                            <input type="number" id="default_price" class="form-control" step="any">
                        </div>

                        <div class="col-md-6">
                            <label>Số lượng mặc định</label>
                            <input type="number" id="default_quantity" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-3" onclick="generateVariants()">Tạo biến thể</button>

            <ul id="variantList"></ul>
            <input type="hidden" name="variants_json" id="variants_json">

            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
        </form>


    </div>
@endsection
