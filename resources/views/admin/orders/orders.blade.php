@extends('admin.layouts.AdminLayouts')

@section('title')
  <title>Quản lý người dùng</title>
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row g-4 mb-4">
    <div class="col-md-12">
      {{-- tìm kiếm đơn hàng --}}
            <form class="d-flex mb-1" role="search" action="/timkiem" method="GET">
        <div class="input-group ">
          <span class="input-group-text bg-light" id="search-icon">
            <i class="bi bi-search"></i>
          </span>
          <input 
            type="text" 
            class="form-control" 
            placeholder="Tìm kiếm đơn hàng" 
            aria-label="Tìm kiếm" 
            aria-describedby="search-icon" 
            name="q"
          >
            <div class="col-auto">
          <select class="form-select ms-1" name="">
            <option value="">--Tất cả Trạng thái--</option>
            <option value="1" >Đã giao hàng</option>
            <option value="2" >Chờ xác nhận</option>
            <option value="3" >Đã hủy</option>
            <option value="4" >Đã thanh toán</option>
          </select>
        </div>
          <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
      </form>
      {{-- kết thúc tìm kiếm --}}
      <table class="table table-bordered table-striped table-hover text-center">
       <thead>
        <tr>
          <th scope="col">Mã đơn hàng</th>
          <th scope="col">Ngày đặt hàng</th>
          <th scope="col">Tên người nhận</th>
          <th scope="col">Địa chỉ</th>
          <th scope="col">Số điện thoại</th>
          <th scope="col">Trạng thái</th>
          <th scope="col">Thao tác</th>
        </tr>
       </thead>
       <tbody>
        <tr>
          <td>DH001</td>
          <td>2023-10-01</td>
          <td>Nguyễn Văn A</td>
          <td>123 Đường ABC</td>
          <td>0123456789</td>
          <td><span class="badge bg-success">Đã giao hàng</span></td>
          <td>              
                            <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                              <button class="btn btn-sm btn-success me-1">
                                <i class="bi bi-pencil-square"></i> Xác nhân
                            </button>
          </td>
        </tr>
        <tr>
          <td>DH002</td>
          <td>2023-10-02</td>
          <td>Trần Thị B</td>
          <td>456 Đường DEF</td>
          <td>0987654321</td>
          <td><span class="badge bg-warning">Đang giao hàng</span></td>
          <td>
          <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                              <button class="btn btn-sm btn-success me-1">
                                <i class="bi bi-pencil-square"></i> Xác nhân
                            </button>
          </td>
        </tr>
        <tr>
          <td>DH003</td>
          <td>2023-10-03</td>
          <td>Nguyễn Thị C</td>
          <td>789 Đường GHI</td>
          <td>0123456789</td>
          <td><span class="badge bg-danger">Chưa giao hàng</span></td>
          <td>
            <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                              <button class="btn btn-sm btn-success me-1">
                                <i class="bi bi-pencil-square"></i> Xác nhân
                            </button>
          </td>
        </tr>
        <tr>
          <td>DH004</td>
          <td>2023-10-04</td>
          <td>Nguyễn Văn D</td>
          <td>321 Đường JKL</td>
          <td>0987654321</td>
          <td><span class="badge bg-info">Đang xử lý</span></td>
          <td>
           <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                              <button class="btn btn-sm btn-success me-1">
                                <i class="bi bi-pencil-square"></i> Xác nhân
                            </button>
          </td>
        </tr>
        <tr>
          <td>DH005</td>
          <td>2023-10-05</td>
          <td>Trần Văn E</td>
          <td>654 Đường MNO</td>
          <td>0123456789</td>
          <td><span class="badge bg-secondary">Đã hủy</span></td>
          <td>
           <button class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-info-circle"></i> Chi tiết
                            </button>
                              <button class="btn btn-sm btn-success me-1">
                                <i class="bi bi-pencil-square"></i> Xác nhân
                            </button>
          </td>
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
   
  </div>
 </div>
</div>
@endsection