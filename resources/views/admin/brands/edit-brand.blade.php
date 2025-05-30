@extends('admin.layouts.AdminLayouts')
@section('title-page')
<h3>Chỉnh sửa thương hiệu</h3>
@endsection

@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    {{-- class này là độ dài tối đa --}}
    <div class="row g-4 mb-4 justify-content-center">
      {{-- class này là làm bố cục lên cùng hàng --}}
    <div class="col-md-8 ">
        {{-- ở dây chứa nội dung bên trái --}}
        <a href="{{ route('brands') }}" class="btn btn-outline-danger w-100">Back</a>
         <form action="{{ route('brands.update', $brand->id) }}" method="POST" class="form-control border border-2 p-4"
             enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name">Tên thương hiệu:</label>
                <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
            </div>
            <div class="mb-3">
                <label for="slug">Slug:</label>
                <input type="text" name="slug" class="form-control" value="{{ $brand->slug }}" required>
            </div>
           <div class="mb-3">
            <label for="image">Hình ảnh thư viện:</label>
            <input type="file" name="image" class="form-control">
            @if($brand->image)
                <img src="{{ asset('storage/' . $brand->image) }}" alt="Thương hiệu" width="100">
            @endif
        </div>

            <div class="mb-3">
                <label for="status">Trạng thái:</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>Ngừng bán</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning w-100 mb-2">Cập nhật</button>
        </form>
    </div>
    </div>
        
      
</div>

@endsection