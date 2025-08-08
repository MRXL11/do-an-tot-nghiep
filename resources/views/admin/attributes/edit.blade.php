@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Chỉnh sửa Thuộc tính</h3>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-danger mb-2">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST" class="form-control border border-2 p-4">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên thuộc tính</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $attribute->name) }}" class="form-control">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    
                    {{-- Phần chỉnh sửa các giá trị đã có --}}
                    <label class="form-label fw-bold">Chỉnh sửa giá trị hiện có</label>
                    @forelse($attribute->values as $value)
                        <div class="input-group mb-2">
                            <input type="text" name="existing_values[{{ $value->id }}]" value="{{ $value->value }}" class="form-control">
                            <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-value-form-{{ $value->id }}').submit();">Xóa</a>
                        </div>
                    @empty
                        <p class="text-muted">Chưa có giá trị nào.</p>
                    @endforelse

                    <hr>

                    {{-- Phần thêm giá trị mới --}}
                    <div id="values-wrapper">
                        <label class="form-label fw-bold">Thêm giá trị mới</label>
                        <div class="input-group mb-2">
                            <input type="text" name="values[]" class="form-control" placeholder="Giá trị mới">
                            <button class="btn btn-danger" type="button" onclick="removeValue(this)">Xóa</button>
                        </div>
                    </div>
                    @error('values.*')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror

                    <button type="button" class="btn btn-outline-primary mt-2" onclick="addValue()">
                        <i class="bi bi-plus-circle"></i> Thêm giá trị
                    </button>

                    <hr>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-arrow-clockwise"></i> Cập nhật</button>
                </form>

                {{-- Các form xóa ẩn --}}
                @foreach($attribute->values as $value)
                    <form id="delete-value-form-{{ $value->id }}" action="{{ route('admin.attributes.destroyValue', $value->id) }}" method="POST" style="display: none;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa giá trị này?')">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function addValue() {
        const wrapper = document.getElementById('values-wrapper');
        const newValue = document.createElement('div');
        newValue.className = 'input-group mb-2';
        newValue.innerHTML = `
            <input type="text" name="values[]" class="form-control" placeholder="Giá trị mới">
            <button class="btn btn-danger" type="button" onclick="removeValue(this)">Xóa</button>
        `;
        wrapper.appendChild(newValue);
    }

    function removeValue(button) {
        button.parentElement.remove();
    }
</script>
@endsection