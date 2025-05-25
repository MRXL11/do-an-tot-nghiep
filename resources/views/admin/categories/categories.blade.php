@extends('admin.layouts.AdminLayouts')

@section('title')
  <title>Quản lý người dùng</title>
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row g-4 mb-4">
    <div class="col-md-9">
      {{-- tìm kiếm danh muc --}}
            <form class="d-flex mb-1" role="search" action="/timkiem" method="GET">
        <div class="input-group ">
          <span class="input-group-text bg-light" id="search-icon">
            <i class="bi bi-search"></i>
          </span>
          <input 
            type="text" 
            class="form-control" 
            placeholder="Tìm kiếm danh mục" 
            aria-label="Tìm kiếm" 
            aria-describedby="search-icon" 
            name="q"
          >
            <div class="col-auto">
          <select class="form-select ms-1" name="">
            <option value="">--Tất cả Trạng thái--</option>
            <option value="1" >Còn bán</option>
            <option value="2" >Ngừng bán</option>
            <option value="3" >Đã xóa</option>
            <option value="4" >Đã cập nhật</option>
            <option value="5" >Mới tạo</option>
          </select>
        </div>
          <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
      </form>
      {{-- kết thúc tìm kiếm --}}
      <table class="table table-bordered table-striped table-hover text-center">
      <thead>
        <tr>
          <th scope="col">STT</th>
          <th scope="col">Tên danh mục</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Ngày cập nhật</th>
            <th scope="col">Người tạo</th>
            <th scope="col">Trạng thái</th>
            <th scope="col" width="237">Thao tác</th>
        </tr>
      </thead>
      <tbody>
            <tr>
            <td scope="row">1</td>
            <td>áo len</td>
            <td>
              <img src="https://tse4.mm.bing.net/th?id=OIP.b8VsmTdWxULu3CK7sQUMFAHaJ4&pid=Api&P=0&h=180" alt="" width="50px" height="50px">
            </td>
            <td>áo len nam</td>
            <td>2023-10-01</td>
            <td>2023-10-01</td>
            <td>Nguyễn Văn A</td>
            <td><span class="badge bg-success">Ngừng bán</span></td>
            <td>
              <button class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                            <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Xoá
                            </button>
            </td>
            </tr>
            <tr>
            <td scope="row">2</td>
            <td>áo sơ mi</td>
            <td>
              <img src="https://tse4.mm.bing.net/th?id=OIP.b8VsmTdWxULu3CK7sQUMFAHaJ4&pid=Api&P=0&h=180" alt="" width="50px" height="50px">
            </td>
            <td>áo sơ mi nam</td>
            <td>2023-10-01</td>
            <td>2023-10-01</td>
            <td>Nguyễn Văn A</td>
            <td><span class="badge bg-success">Còn bán</span></td>
            <td>
              <button class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                            <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Xoá
                            </button>
            </td>
            </tr>
              <tr>
            <td scope="row">2</td>
            <td>áo sơ mi</td>
            <td>
              <img src="https://tse4.mm.bing.net/th?id=OIP.b8VsmTdWxULu3CK7sQUMFAHaJ4&pid=Api&P=0&h=180" alt="" width="50px" height="50px">
            </td>
            <td>áo sơ mi nam</td>
            <td>2023-10-01</td>
            <td>2023-10-01</td>
            <td>Nguyễn Văn A</td>
            <td><span class="badge bg-success">Còn bán</span></td>
            <td>
               <button class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                            <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Xoá
                            </button>
            </td>
            </tr>
              <tr>
            <td scope="row">2</td>
            <td>áo sơ mi</td>
            <td>
              <img src="https://tse4.mm.bing.net/th?id=OIP.b8VsmTdWxULu3CK7sQUMFAHaJ4&pid=Api&P=0&h=180" alt="" width="50px" height="50px">
            </td>
            <td>áo sơ mi nam</td>
            <td>2023-10-01</td>
            <td>2023-10-01</td>
            <td>Nguyễn Văn A</td>
            <td><span class="badge bg-success">Còn bán</span></td>
            <td>
               <button class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                            <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Xoá
                            </button>
            </td>
            </tr>
              <tr>
            <td scope="row">2</td>
            <td>áo sơ mi</td>
            <td>
              <img src="https://tse4.mm.bing.net/th?id=OIP.b8VsmTdWxULu3CK7sQUMFAHaJ4&pid=Api&P=0&h=180" alt="" width="50px" height="50px">
            </td>
            <td>áo sơ mi nam</td>
            <td>2023-10-01</td>
            <td>2023-10-01</td>
            <td>Nguyễn Văn A</td>
            <td><span class="badge bg-success">Còn bán</span></td>
            <td>
               <button class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>
                            <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Xoá
                            </button>
            </tr>
      </tbody>
      </table>
      {{-- đây là paginate phân trang --}}
      <div class="d-flex justify-content-center">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">4</a></li>
          <li class="page-item"><a class="page-link" href="#">5</a></li>
        </ul> 
      </div>
      {{-- kết thúc phân trang --}}
    </div>
    <div class="col-md-3">
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">TOP Danh mục bán chạy</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
          <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
          <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
        </button>
      </div>
    </div>

    <!-- Danh mục 1 -->
    <div class="card-body border-bottom d-flex align-items-center gap-2">
      <img src="https://tse1.mm.bing.net/th?id=OIP.B9OwLAa-NJ8fajNWalNA6QHaJ4&pid=Api&P=0&h=180" alt="img" class="rounded" height="30px">
      <strong><a href="#" class="text-decoration-none ms-4">Quần áo nam</a></strong>
   
    </div>

    <!-- Danh mục 2 -->
    <div class="card-body border-bottom d-flex align-items-center gap-2">
      <img src="https://tse1.mm.bing.net/th?id=OIP.B9OwLAa-NJ8fajNWalNA6QHaJ4&pid=Api&P=0&h=180" alt="img" class="rounded" height="30px">
     <strong> <a href="#" class="text-decoration-none ms-4">Quần áo nữ</a></strong>

    </div>

    <!-- Danh mục 3 -->
    <div class="card-body border-bottom d-flex align-items-center gap-2">
      <img src="https://tse1.mm.bing.net/th?id=OIP.B9OwLAa-NJ8fajNWalNA6QHaJ4&pid=Api&P=0&h=180" alt="img" class="rounded" height="30px">
      <strong><a href="#" class="text-decoration-none ms-4">Thời trang trẻ em</a></strong>
    
    </div>

    <!-- Bạn có thể lặp lại đến 10 danh mục -->
    <!-- Danh mục 3 -->
    <div class="card-body border-bottom d-flex align-items-center gap-2">
      <img src="https://tse1.mm.bing.net/th?id=OIP.B9OwLAa-NJ8fajNWalNA6QHaJ4&pid=Api&P=0&h=180" alt="img" class="rounded" height="30px">
      <strong><a href="#" class="text-decoration-none ms-4">Thời trang trẻ em</a></strong>
    
    </div>
    <!-- Danh mục 3 -->
    <div class="card-body border-bottom d-flex align-items-center gap-2">
      <img src="https://tse1.mm.bing.net/th?id=OIP.B9OwLAa-NJ8fajNWalNA6QHaJ4&pid=Api&P=0&h=180" alt="img" class="rounded" height="30px">
      <strong><a href="#" class="text-decoration-none ms-4">Thời trang trẻ em</a></strong>
    
    </div>
    <!-- Danh mục 3 -->
    <div class="card-body border-bottom d-flex align-items-center gap-2">
      <img src="https://tse1.mm.bing.net/th?id=OIP.B9OwLAa-NJ8fajNWalNA6QHaJ4&pid=Api&P=0&h=180" alt="img" class="rounded" height="30px">
      <strong><a href="#" class="text-decoration-none ms-4">Thời trang trẻ em</a></strong>
    
    </div>
  </div>
</div>

 </div>
</div>
@endsection