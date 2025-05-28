@extends('admin.layouts.AdminLayouts')

@section('title', 'Chi tiết & Chỉnh sửa sản phẩm')

@section('content')
    <div class="container-fluid">
        <h2>Thông tin sản phẩm</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="productForm" action="{{ route('admin.products.update', $product->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-7">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $product->name }}">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="brand_id" class="form-label">Thương hiệu</label>
                            <select class="form-control" id="brand_id" name="brand_id">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-control" id="category_id" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Kích hoạt
                                </option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Không kích
                                    hoạt
                                </option>
                                <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>Hết
                                    hàng
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="short_description" class="form-label">Mô tả ngắn</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="1">{{ $product->short_description }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Ảnh bên phải -->
                <div class="col-md-5 text-center">
                    <img id="preview_thumbnail" src="{{ Storage::url($product->thumbnail) }}"
                        class="img-fluid rounded mb-2" style="max-height: 400px; object-fit: cover; cursor: pointer;"
                        alt="Ảnh sản phẩm" onclick="document.querySelector('input[name=thumbnail]').click()">
                    <div class="mt-3">
                        <label for="thumbnail" class="form-label d-none" id="label_thumbnail">Chọn ảnh mới</label>
                        <input type="file" id="thumbnail" name="thumbnail" class="form-control d-none" accept="image/*"
                            onchange="previewThumbnail(this)">
                    </div>
                    @error('thumbnail')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Thông tin sản phẩm -->


            <h4>Biến thể sản phẩm</h4>
            @foreach ($product->variants as $i => $variant)
                <div class="card p-3 mb-3">
                    <div class="row g-3 align-items-center">
                        <!-- Ảnh bên trái -->
                        <div class="col-md-5 text-center">
                            <img id="preview_variant_{{ $i }}"
                                src="{{ asset($variant->image ?? 'dist/assets/img/default-150x150.png') }}"
                                class="img-fluid rounded mb-2"
                                style="max-height: 200px; object-fit: cover; cursor: pointer;" alt="Ảnh biến thể"
                                onclick="document.querySelector(`input[name='variants[{{ $i }}][image]']`).click()">
                            <div class="mt-3">
                                <label for="variant_image_{{ $i }}" class="form-label d-none"
                                    id="label_variant_image_{{ $i }}">Chọn ảnh mới</label>
                                <input type="file" id="variant_image_{{ $i }}"
                                    name="variants[{{ $i }}][image]" class="form-control d-none"
                                    accept="image/*" onchange="previewImage(this, {{ $i }})">
                            </div>
                            @error("variants.$i.image")
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Thông tin bên phải -->
                        <div class="col-md-7">
                            <input type="hidden" name="variants[{{ $i }}][id]" value="{{ $variant->id }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>Màu sắc</label>
                                    <input type="text" class="form-control"
                                        name="variants[{{ $i }}][color]"
                                        value="{{ old("variants.$i.color", $variant->color) }}">
                                    @error("variants.$i.color")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Kích cỡ</label>
                                    <input type="text" class="form-control"
                                        name="variants[{{ $i }}][size]"
                                        value="{{ old("variants.$i.size", $variant->size) }}">
                                    @error("variants.$i.size")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Giá</label>
                                    <input type="number" class="form-control"
                                        name="variants[{{ $i }}][price]"
                                        value="{{ old("variants.$i.price", $variant->price) }}" step='any'>
                                    @error("variants.$i.price")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label>Số lượng</label>
                                    <input type="number" class="form-control"
                                        name="variants[{{ $i }}][stock_quantity]"
                                        value="{{ old("variants.$i.stock_quantity", $variant->stock_quantity) }}">
                                    @error("variants.$i.stock_quantity")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="variants[{{ $i }}][status]" class="form-label">Trạng
                                        thái</label>
                                    <select class="form-control" id="variants[{{ $i }}][status]"
                                        name="variants[{{ $i }}][status]">
                                        <option value="active" {{ $variant->status == 'active' ? 'selected' : '' }}>Kích
                                            hoạt
                                        </option>
                                        <option value="inactive" {{ $variant->status == 'inactive' ? 'selected' : '' }}>
                                            Không kích
                                            hoạt
                                        </option>
                                    </select>
                                    @error("variants.$i.status")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-3">
                <button type="submit" id="saveButton" class="btn btn-success">Lưu</button>
            </div>
        </form>
    </div>
@endsection
