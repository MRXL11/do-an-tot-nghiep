@extends('admin.layouts.AdminLayouts')

@section('title-page', 'Chi tiết & Chỉnh sửa sản phẩm')

@section('content')
    <div class="container-fluid">

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

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

        {{-- Form chỉnh sửa sản phẩm --}}
        <form id="productForm" action="{{ route('admin.products.update', $product->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row align-items-center mb-3">
                <!-- Cột trái: Tiêu đề và mô tả -->
                <div class="col-md-6">
                    <h3>Thông tin sản phẩm</h3>
                    <p class="text-muted mb-0">
                        Bạn có thể chỉnh sửa thông tin sản phẩm ở đây!
                    </p>
                </div>

                <!-- Cột phải: Nút bấm -->
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button type="submit" id="saveButton" class="btn btn-success">Lưu</button>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
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

            <div class="row align-items-center mb-3">
                <!-- Cột trái: Tiêu đề và mô tả -->
                <div class="col-md-6">
                    <h3>Biến thể sản phẩm</h3>
                    <p class="text-muted mb-0">
                        Bạn có thể thêm, chỉnh sửa hoặc xóa các biến thể sản phẩm như màu sắc, kích cỡ,
                        giá và số lượng.
                    </p>
                </div>


            </div>

            <!-- Biến thể sản phẩm -->
            @forelse ($product->variants->chunk(3) as $chunk)
                <div class="row">
                    @foreach ($chunk as $j => $variant)
                        <div class="col-12 col-md-4">
                            <div class="card p-3 mb-3">
                                <div class="row g-3">
                                    <!-- Ảnh bên trái -->
                                    <div class="col-12 col-md-5 text-center">
                                        <img id="preview_variant_{{ $loop->parent->index * 2 + $j }}"
                                            src="{{ asset($variant->image) }}" class="img-fluid rounded mb-2"
                                            style="max-height: 200px; object-fit: cover; cursor: pointer;"
                                            alt="Ảnh biến thể"
                                            onclick="document.querySelector(`input[name='variants[{{ $loop->parent->index * 2 + $j }}][image]']`).click()">
                                        <input type="file" id="variant_image_{{ $loop->parent->index * 2 + $j }}"
                                            name="variants[{{ $loop->parent->index * 2 + $j }}][image]"
                                            class="form-control d-none" accept="image/*"
                                            onchange="previewImage(this, {{ $loop->parent->index * 2 + $j }})">
                                        @error('variants.' . ($loop->parent->index * 2 + $j) . '.image')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Thông tin bên phải -->
                                    <div class="col-12 col-md-7">
                                        <input type="hidden" name="variants[{{ $loop->parent->index * 2 + $j }}][id]"
                                            value="{{ $variant->id }}">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label>Màu sắc</label>
                                                <input type="text" class="form-control"
                                                    name="variants[{{ $loop->parent->index * 2 + $j }}][color]"
                                                    value="{{ old('variants.' . ($loop->parent->index * 2 + $j) . '.color', $variant->color) }}">
                                                @error('variants.' . ($loop->parent->index * 2 + $j) . '.color')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label>Kích cỡ</label>
                                                <input type="text" class="form-control"
                                                    name="variants[{{ $loop->parent->index * 2 + $j }}][size]"
                                                    value="{{ old('variants.' . ($loop->parent->index * 2 + $j) . '.size', $variant->size) }}">
                                                @error('variants.' . ($loop->parent->index * 2 + $j) . '.size')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label>Giá</label>
                                                <input type="number" class="form-control"
                                                    name="variants[{{ $loop->parent->index * 2 + $j }}][price]"
                                                    value="{{ old('variants.' . ($loop->parent->index * 2 + $j) . '.price', $variant->price) }}"
                                                    step="any">
                                                @error('variants.' . ($loop->parent->index * 2 + $j) . '.price')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label>Số lượng</label>
                                                <input type="number" class="form-control"
                                                    name="variants[{{ $loop->parent->index * 2 + $j }}][stock_quantity]"
                                                    value="{{ old('variants.' . ($loop->parent->index * 2 + $j) . '.stock_quantity', $variant->stock_quantity) }}">
                                                @error('variants.' . ($loop->parent->index * 2 + $j) . '.stock_quantity')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label>Trạng thái</label>
                                                <select class="form-control"
                                                    name="variants[{{ $loop->parent->index * 2 + $j }}][status]">
                                                    <option value="active"
                                                        {{ $variant->status == 'active' ? 'selected' : '' }}>
                                                        Kích hoạt</option>
                                                    <option value="inactive"
                                                        {{ $variant->status == 'inactive' ? 'selected' : '' }}>
                                                        Không kích hoạt</option>
                                                </select>
                                                @error('variants.' . ($loop->parent->index * 2 + $j) . '.status')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- card -->
                        </div> <!-- col -->
                    @endforeach
                </div> <!-- row -->
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Sản phẩm không có biến thể nào.</div>
                </div>
            @endforelse
        </form>


        {{-- Nút và form thêm biến thể --}}
        <button type="button" id="add_variant" class="btn btn-primary">-- Thêm biến thể --</button>
        <div id="variant_form_container" class="d-none mt-3">
            <form action="{{ route('admin.products.addVariants', $product->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Danh sách màu (phẩy cách)</label>
                        <input type="text" id="colors" class="form-control" placeholder="Đỏ,Trắng,Xanh">
                        <div class="invalid-feedback" id="color_error"></div>
                    </div>
                    <div class="col-md-6">
                        <label>Danh sách size (phẩy cách)</label>
                        <input type="text" id="sizes" class="form-control" placeholder="S,M,L,XL">
                        <div class="invalid-feedback" id="size_error"></div>
                    </div>
                    <div class="col-md-6">
                        <label>Giá mặc định</label>
                        <input type="number" id="default_price" class="form-control" step="any">
                        <div class="invalid-feedback" id="default_price_error"></div>
                    </div>
                    <div class="col-md-6">
                        <label>Số lượng mặc định</label>
                        <input type="number" id="default_quantity" class="form-control">
                        <div class="invalid-feedback" id="default_quantity_error"></div>
                    </div>

                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-success" id="generate_variants"
                            onclick="generateVariants()">Tạo tổ hợp</button>
                        <button type="submit" class="btn btn-info">Lưu</button>
                    </div>

                    <!-- Hidden input để chứa JSON -->
                    <input type="hidden" name="variants" id="variants">
                </div>

                <div class="mt-3">
                    <strong>Các tổ hợp đã tạo:</strong>
                    <ul id="variantList"></ul>
                </div>
            </form>
        </div>
    </div>
@endsection
