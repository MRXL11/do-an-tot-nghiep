@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Thêm mới Thuộc tính</h3>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-danger mb-2">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <form action="{{ route('admin.attributes.store') }}" method="POST" class="form-control border border-2 p-4">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên thuộc tính</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Ví dụ: Màu sắc">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="values-wrapper">
                        <label class="form-label fw-bold">Các giá trị</label>
                        <div class="input-group mb-2">
                            <input type="text" name="values[]" class="form-control" placeholder="Ví dụ: Đỏ">
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
                    <button type="submit" class="btn btn-success w-30"><i class="bi bi-plus-circle"></i> Tạo mới</button>
                </form>
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