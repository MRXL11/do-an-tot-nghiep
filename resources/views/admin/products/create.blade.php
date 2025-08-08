@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Thêm sản phẩm</h3>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- Phần thông báo giữ nguyên code cũ của bạn --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @php $uniqueErrors = array_unique($errors->all()); @endphp
                    @foreach ($uniqueErrors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form thêm sản phẩm --}}
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Phần thông tin sản phẩm chung giữ nguyên code cũ của bạn --}}
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-5 text-center">
                    <img id="preview_thumbnail" src="https://via.placeholder.com/400x300?text=Preview" class="img-fluid rounded mb-2" style="max-height: 400px; object-fit: cover; cursor: pointer;" alt="Ảnh sản phẩm" onclick="document.querySelector('input[name=thumbnail]').click()">
                    <input type="file" id="thumbnail" name="thumbnail" class="form-control d-none" accept="image/*" onchange="previewThumbnail(this)">
                    @error('thumbnail')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-7">
                    <div class="row g-3">
                        <div class="col-md-6"><label for="name" class="form-label">Tên sản phẩm</label><input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}"></div>
                        <div class="col-md-6"><label for="category_id" class="form-label">Danh mục</label><select name="category_id" class="form-control" id="category_id">@foreach ($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label for="brand_id" class="form-label">Thương hiệu</label><select name="brand_id" class="form-control" id="brand_id">@foreach ($brands as $brand)<option value="{{ $brand->id }}">{{ $brand->name }}</option>@endforeach</select></div>
                        <div class="col-md-6"><label for="status" class="form-label">Trạng thái</label><select name="status" class="form-control" id="status"><option value="active">Kích hoạt</option><option value="inactive">Tạm ẩn</option><option value="out_of_stock">Hết hàng</option></select></div>
                        <div class="col-md-12"><label for="short_description" class="form-label">Mô tả ngắn</label><input type="text" name="short_description" class="form-control" id="short_description" value="{{ old('short_description') }}"></div>
                        <div class="col-md-12"><label for="description" class="form-label">Mô tả chi tiết</label><textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea></div>
                    </div>
                </div>
            </div>
            <hr>

            {{-- [BẮT ĐẦU THAY ĐỔI] Thông tin biến thể --}}
            <h4>Thông tin biến thể</h4>
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-12">
                    <div class="row g-3">
                        @php
                            $colorAttribute = $attributes->firstWhere('name', 'Color');
                            $sizeAttribute = $attributes->firstWhere('name', 'Size');
                        @endphp

                        @if($colorAttribute)
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ $colorAttribute->name }}</label>
                            <div class="attribute-checkbox-container p-2 border rounded" style="max-height: 150px; overflow-y: auto;">
                                @foreach($colorAttribute->values as $value)
                                <div class="form-check">
                                    <input class="form-check-input color-checkbox" type="checkbox" value="{{ $value->id }}" id="color_{{ $value->id }}" data-text="{{ $value->value }}">
                                    <label class="form-check-label" for="color_{{ $value->id }}">{{ $value->value }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($sizeAttribute)
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ $sizeAttribute->name }}</label>
                            <div class="attribute-checkbox-container p-2 border rounded" style="max-height: 150px; overflow-y: auto;">
                                @foreach($sizeAttribute->values as $value)
                                <div class="form-check">
                                    <input class="form-check-input size-checkbox" type="checkbox" value="{{ $value->id }}" id="size_{{ $value->id }}" data-text="{{ $value->value }}">
                                    <label class="form-check-label" for="size_{{ $value->id }}">{{ $value->value }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6"><label>Giá nhập mặc định</label><input type="number" id="default_import_price" name='default_import_price' class="form-control" step="any" value="{{ old('default_import_price', 0) }}"></div>
                        <div class="col-md-6"><label>Số lượng mặc định</label><input type="number" id="default_quantity" name='default_quantity' class="form-control" value="{{ old('default_quantity', 0) }}"></div>
                        <div class="col-md-6"><label>Giá bán mặc định</label><input type="number" id="default_price" name='default_price' class="form-control" step="any" value="{{ old('default_price', 0) }}"></div>
                    </div>
                </div>
            </div>
            {{-- [KẾT THÚC THAY ĐỔI] --}}

            <button type="button" class="btn btn-secondary mb-3" onclick="generateVariants()">Tạo biến thể</button>
            <ul id="variantList"></ul>
            <input type="hidden" name="variants" id="variants">
            <div class="row mt-3">
                <div class="col-md-12">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    function previewThumbnail(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('preview_thumbnail').src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }

    function generateSku(length = 8) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let sku = '';
        for (let i = 0; i < length; i++) {
            sku += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return sku;
    }

    function generateVariants() {
        const selectedColors = [];
        document.querySelectorAll('.color-checkbox:checked').forEach(checkbox => {
            selectedColors.push({ id: checkbox.value, text: checkbox.dataset.text });
        });

        const selectedSizes = [];
        document.querySelectorAll('.size-checkbox:checked').forEach(checkbox => {
            selectedSizes.push({ id: checkbox.value, text: checkbox.dataset.text });
        });

        const price = document.getElementById('default_price').value;
        const importPrice = document.getElementById('default_import_price').value;
        const quantity = document.getElementById('default_quantity').value;

        if (selectedColors.length === 0 || selectedSizes.length === 0) {
            alert("Vui lòng chọn ít nhất một màu và một size!");
            return;
        }
        if (!price || !quantity || !importPrice) {
            alert("Vui lòng nhập đủ giá bán, giá nhập và số lượng!");
            return;
        }

        const variants = [];
        let html = '';
        
        selectedColors.forEach(color => {
            selectedSizes.forEach(size => {
                const sku = generateSku();
                const variantName = `${color.text} - ${size.text}`;
                
                variants.push({
                    attribute_ids: [color.id, size.id],
                    price: price,
                    quantity: quantity,
                    import_price: importPrice,
                    sku: sku,
                    name: variantName
                });
                html += `<li>${variantName} | SL: ${quantity} | Giá: ${price} | Giá nhập: ${importPrice} | SKU: ${sku}</li>`;
            });
        });

        document.getElementById('variantList').innerHTML = html;
        document.getElementById('variants').value = JSON.stringify(variants);
    }
</script>
@endsection