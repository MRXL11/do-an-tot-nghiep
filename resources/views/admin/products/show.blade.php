@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Chi tiết & Chỉnh sửa sản phẩm <strong class="text-primary">{{ $product->name }}</strong></h3>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- Phần thông báo (Giữ nguyên) --}}
        @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if (session('error'))<div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach (array_unique($errors->all()) as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        {{-- Form chính để cập nhật toàn bộ sản phẩm và các biến thể đã có --}}
        <form id="productForm" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Phần thông tin chung của sản phẩm (Giữ nguyên cấu trúc gốc của bạn) --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thông tin chung</h5>
                    <div>
                        <a type="button" class="btn btn-secondary me-2" href="{{ route('admin.products.index') }}"><i class="bi bi-arrow-left"></i> Quay lại</a>
                        <button type="submit" id="saveButton" class="btn btn-primary">Lưu tất cả thay đổi</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-7">
                             <div class="row g-3">
                                <div class="col-12"><label for="name" class="form-label">Tên sản phẩm</label><input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}"></div>
                                <div class="col-md-6"><label for="brand_id" class="form-label">Thương hiệu</label><select class="form-select" id="brand_id" name="brand_id">@foreach ($brands as $brand)<option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>@endforeach</select></div>
                                <div class="col-md-6"><label for="category_id" class="form-label">Danh mục</label><select class="form-select" id="category_id" name="category_id">@foreach ($categories as $category)<option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach</select></div>
                                <div class="col-md-6"><label for="status" class="form-label">Trạng thái</label><select class="form-select" id="status" name="status"><option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Kích hoạt</option><option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option></select></div>
                                <div class="col-12"><label for="short_description" class="form-label">Mô tả ngắn</label><textarea class="form-control" id="short_description" name="short_description" rows="2">{{ $product->short_description }}</textarea></div>
                                <div class="col-12"><label for="description" class="form-label">Mô tả</label><textarea class="form-control" id="description" name="description" rows="4">{{ $product->description }}</textarea></div>
                            </div>
                        </div>
                        <div class="col-md-5 text-center">
                            <label class="form-label fw-bold">Ảnh đại diện</label>
                            <img id="preview_thumbnail" src="{{ $product->thumbnail ? Storage::url($product->thumbnail) : 'https://via.placeholder.com/400' }}" class="img-fluid rounded shadow-sm" style="max-height: 350px; object-fit: cover; cursor: pointer;" alt="Ảnh sản phẩm" onclick="document.querySelector('input[name=thumbnail]').click()">
                            <input type="file" id="thumbnail" name="thumbnail" class="form-control d-none" accept="image/*" onchange="previewThumbnail(this)">
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h4 class="mb-3">Biến thể sản phẩm</h4>
            
            {{-- [BẮT ĐẦU NÂNG CẤP] - Giữ nguyên bố cục card nhưng thay đổi nội dung --}}
            @php $variant_index = 0; @endphp
            @forelse ($product->variants->chunk(3) as $chunk)
                <div class="row">
                    @foreach ($chunk as $variant)
                        <div class="col-12 col-md-4">
                            <div class="card p-3 mb-3 h-100">
                                <input type="hidden" name="variants[{{ $variant_index }}][id]" value="{{ $variant->id }}">
                                <div class="row g-3">
                                    <div class="col-12 text-center">
                                        <label class="form-label fw-semibold">Ảnh biến thể</label>
                                        <img id="preview_variant_{{ $variant_index }}" src="{{ $variant->image ? asset($variant->image) : 'https://via.placeholder.com/150' }}" class="img-fluid rounded mb-2" style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;" alt="Ảnh biến thể" onclick="document.getElementById('variant_image_{{ $variant_index }}').click()">
                                        <input type="file" id="variant_image_{{ $variant_index }}" name="variants[{{ $variant_index }}][image]" class="form-control d-none" accept="image/*" onchange="previewVariantImage(this, {{ $variant_index }})">
                                    </div>
                                    <div class="col-12">
                                        <div class="row g-2">
                                            {{-- Vòng lặp để hiển thị thuộc tính bằng dropdown --}}
                                            @foreach($attributes as $attribute)
                                                <div class="col-6">
                                                    <label class="form-label">{{ $attribute->name }}</label>
                                                    <select class="form-select" name="variants[{{ $variant_index }}][attributes][]">
                                                        @foreach($attribute->values as $value)
                                                            <option value="{{ $value->id }}" @selected($variant->attributes->contains('id', $value->id))>
                                                                {{ $value->value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endforeach

                                            {{-- Các ô nhập liệu khác (Giữ nguyên) --}}
                                            <div class="col-6"><label>Giá nhập</label><input type="number" class="form-control" name="variants[{{ $variant_index }}][import_price]" value="{{ $variant->import_price }}" step="any"></div>
                                            <div class="col-6"><label>Giá bán</label><input type="number" class="form-control" name="variants[{{ $variant_index }}][price]" value="{{ $variant->price }}" step="any"></div>
                                            <div class="col-6"><label>Số lượng</label><input type="number" class="form-control" name="variants[{{ $variant_index }}][stock_quantity]" value="{{ $variant->stock_quantity }}"></div>
                                            <div class="col-6"><label>Trạng thái</label><select class="form-select" name="variants[{{ $variant_index }}][status]"><option value="active" @selected($variant->status == 'active')>Kích hoạt</option><option value="inactive" @selected($variant->status == 'inactive')>Không kích hoạt</option></select></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $variant_index++; @endphp
                    @endforeach
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">Sản phẩm không có biến thể nào.</div></div>
            @endforelse
        </form>
        {{-- [KẾT THÚC NÂNG CẤP] --}}


        {{-- Form thêm biến thể mới (Giữ nguyên cấu trúc gốc của bạn nhưng nâng cấp nội dung) --}}
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thêm biến thể mới</h5>
                <button type="button" id="add_variant_btn" class="btn btn-outline-primary btn-sm">Hiện Form</button>
            </div>
            <div id="variant_form_container" class="card-body" style="display: none;">
                <form action="{{ route('admin.products.addVariants', $product->id) }}" method="POST">
                    @csrf
                     {{-- Nâng cấp phần chọn màu/size thành checkbox --}}
                    <div class="row g-3">
                        @php
                            $colorAttribute = $attributes->firstWhere('name', 'Color');
                            $sizeAttribute = $attributes->firstWhere('name', 'Size');
                        @endphp
                        @if($colorAttribute)
                        <div class="col-md-6"><label class="form-label fw-bold">{{ $colorAttribute->name }}</label><div class="p-2 border rounded" style="max-height: 150px; overflow-y: auto;">@foreach($colorAttribute->values as $value)<div class="form-check"><input class="form-check-input color-checkbox" type="checkbox" value="{{ $value->id }}" data-text="{{ $value->value }}"><label class="form-check-label">{{ $value->value }}</label></div>@endforeach</div></div>
                        @endif
                        @if($sizeAttribute)
                        <div class="col-md-6"><label class="form-label fw-bold">{{ $sizeAttribute->name }}</label><div class="p-2 border rounded" style="max-height: 150px; overflow-y: auto;">@foreach($sizeAttribute->values as $value)<div class="form-check"><input class="form-check-input size-checkbox" type="checkbox" value="{{ $value->id }}" data-text="{{ $value->value }}"><label class="form-check-label">{{ $value->value }}</label></div>@endforeach</div></div>
                        @endif
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-4"><label>Giá nhập mặc định</label><input type="number" id="default_import_price" class="form-control" value="0" step="any"></div>
                        <div class="col-md-4"><label>Giá bán mặc định</label><input type="number" id="default_price" class="form-control" value="0" step="any"></div>
                        <div class="col-md-4"><label>Số lượng mặc định</label><input type="number" id="default_quantity" class="form-control" value="0"></div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" onclick="generateVariants()">Tạo tổ hợp</button>
                        <button type="submit" class="btn btn-info">Lưu biến thể mới</button>
                    </div>
                    <input type="hidden" name="variants" id="variants_json">
                    <div class="mt-3"><strong>Các tổ hợp đã tạo:</strong><ul id="variantList"></ul></div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        // Hàm preview ảnh thumbnail (giữ nguyên)
        function previewThumbnail(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('preview_thumbnail').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Hàm preview ảnh cho từng biến thể (giữ nguyên)
        function previewVariantImage(input, index) {
            const preview = document.getElementById(`preview_variant_${index}`);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Hàm tạo SKU (giữ nguyên)
        function generateSku(length = 8) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; let sku = '';
            for (let i = 0; i < length; i++) { sku += chars.charAt(Math.floor(Math.random() * chars.length)); }
            return sku;
        }

        // Hàm tạo biến thể cho form "Thêm mới" (giữ nguyên)
        function generateVariants() {
            const selectedColors = []; document.querySelectorAll('.color-checkbox:checked').forEach(c => selectedColors.push({ id: c.value, text: c.dataset.text }));
            const selectedSizes = []; document.querySelectorAll('.size-checkbox:checked').forEach(s => selectedSizes.push({ id: s.value, text: s.dataset.text }));
            if (selectedColors.length === 0 || selectedSizes.length === 0) { alert("Vui lòng chọn ít nhất một màu và một size!"); return; }
            const price = document.getElementById('default_price').value;
            const importPrice = document.getElementById('default_import_price').value;
            const quantity = document.getElementById('default_quantity').value;
            if (!price || !quantity || !importPrice) { alert("Vui lòng nhập đủ giá bán, giá nhập và số lượng!"); return; }
            const variants = []; let html = '';
            selectedColors.forEach(color => {
                selectedSizes.forEach(size => {
                    const sku = generateSku(); const variantName = `${color.text} - ${size.text}`;
                    variants.push({ attribute_ids: [color.id, size.id], price, quantity, import_price: importPrice, sku, name: variantName });
                    html += `<li>${variantName} | SL: ${quantity} | Giá: ${price} | Giá nhập: ${importPrice} | SKU: ${sku}</li>`;
                });
            });
            document.getElementById('variantList').innerHTML = html;
            document.getElementById('variants_json').value = JSON.stringify(variants);
        }

        // Mở/đóng form thêm biến thể (giữ nguyên)
        document.getElementById('add_variant_btn').addEventListener('click', function() {
            const formContainer = document.getElementById('variant_form_container');
            if (formContainer.style.display === 'none') {
                formContainer.style.display = 'block';
                this.textContent = 'Ẩn Form';
            } else {
                formContainer.style.display = 'none';
                this.textContent = 'Hiện Form';
            }
        });
    </script>
@endsection