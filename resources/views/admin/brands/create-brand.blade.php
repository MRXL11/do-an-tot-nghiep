@extends('admin.layouts.AdminLayouts')
@section('title-page')
    <h3>Thêm mới thương hiệu</h3>
@endsection

@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    {{-- class này là độ dài tối đa --}}
    <div class="row g-4 mb-4 justify-content-center">
      {{-- class này là làm bố cục lên cùng hàng --}}
    <div class="col-md-8 ">
        {{-- ở dây chứa nội dung bên trái --}}
         <form action="{{ route('brands.store') }}" method="POST" class="form-control border border-2 p-4"
            {{-- enctype là để upload file --}}
          enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name">Tên thương hiệu:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="slug">Slug:</label>
                <input type="text" name="slug" class="form-control" required>
            </div>
             <div class="mb-3">
                <label for="image">Hình ảnh:</label>
                <input type="file" name="image" class="form-control">
            </div>
            
            <div class="mb-3">
                <label for="status">Trạng thái:</label>
                <select name="status" class="form-control">
                    <option value="active">Kích hoạt</option>
                    <option value="inactive">Ngừng hoạt động</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Tạo mới</button>
        </form>
    </div>
    </div>
        
      
</div>

@endsection