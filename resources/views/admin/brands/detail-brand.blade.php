@extends('admin.layouts.AdminLayouts')



@section('title-page')
 <h3 class="text-primary">Thông tin chi tiết thương hiệu</h3>
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-lg-12 justify-content-center">
    {{-- class này là độ dài tối đa --}}
    <div class="row g-4 mb-4 border shadow-sm p-5">
        
    <div class="col-md-4 border p-3">
        {{-- ở đây chứa nội dung bên trái --}}
        <a href="{{ route('brands') }}" class="btn btn-primary form-control mb-2">Danh sách</a>
        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning form-control">Sửa</a>
    </div>
    <div class="col-md-4 text-center border">
        {{-- ở dây chứa nội dung bên trái --}}
        <p><strong>Ảnh:</strong></p>
        <img class="img-fluid mb-1"
        src="{{ $brand->image ? asset('storage/' . $brand->image) : asset('images/placeholder.png') }}"
        alt="{{ $brand->name }}"
        style="width: 200px; height: 200px; object-fit: cover;">
    </div>
   
      <div class="col-md-4 border">
        {{-- ở đây chứa nội dung bên phải       --}}
         <p><strong>ID:</strong> {{ $brand->id }}</p>
    <p><strong>Tên:</strong> {{ $brand->name }}</p>
    <p><strong>Slug:</strong> {{ $brand->slug }}</p>
    <p><strong>Trạng thái:</strong> {{ $brand->status }}</p>
    <p><strong>Ngày tạo:</strong> {{ $brand->created_at->format('d-m-Y H:i:s') }}</p>
    <p><strong>Ngày cập nhật:</strong> {{ $brand->updated_at->format('d-m-Y H:i:s') }}</p>

    </div>
  </div>
 </div>
</div>
@endsection
