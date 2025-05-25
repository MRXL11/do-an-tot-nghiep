@extends('admin.layouts.AdminLayouts')

@section('title')
  <title>Quản lý người dùng</title>
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row g-4 mb-4">
    <div class="col-md-8">
      {{-- tìm kiếm người dùng --}}
            <form class="d-flex mb-1" role="search" action="/timkiem" method="GET">
        <div class="input-group">
          <span class="input-group-text bg-light" id="search-icon">
            <i class="bi bi-search"></i>
          </span>
          <input 
            type="text" 
            class="form-control" 
            placeholder="Tìm kiếm người dùng" 
            aria-label="Tìm kiếm" 
            aria-describedby="search-icon" 
            name="q"
          >
          <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
      </form>
      {{-- kết thúc tìm kiếm người dùng --}}
      <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th class="text-center">STT</th>
            <th class="text-center">Họ tên</th>
            <th class="text-center">Email</th>
            <th class="text-center">Số điện thoại</th>
            <th class="text-center">Địa chỉ</th>
            <th class="text-center">Quyền</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center">1</td>
            <td class="text-center">Nguyễn Văn A</td>
            <td class="text-center">
              <a href="mailto:sH4l9@example.com">sH4l9@example.com</a>
            </td>
            <td class="text-center">0123456789</td>
            <td class="text-center">Hà Nội</td>
            <td class="text-center">user</td>
            <td class="text-center text-success fw-bold">active 4days ago</td>
            <td class="text-center">
              <a href="javascript:" class="btn btn-primary btn-sm">Sửa</a> <a href="javascript:" class="btn btn-info btn-sm">xem</a>
              <a href="javascript:" class="btn btn-danger btn-sm">Xóa</a>
            </td>
          </tr>
          <tr>
            <td class="text-center">2</td>
            <td class="text-center">Nguyễn Văn B</td>
            <td class="text-center">
              <a href="mailto:sH4l9@example.com">sH4l9@example.com</a>
            </td>
            <td class="text-center">0123456789</td>
            <td class="text-center">Hà Nội</td>
            <td class="text-center">user</td>
            <td class="text-center text-success fw-bold">online 1days ago</td>
            <td class="text-center">
              <a href="javascript:" class="btn btn-primary btn-sm">Sửa</a> <a href="javascript:" class="btn btn-info btn-sm">xem</a>
              <a href="javascript:" class="btn btn-danger btn-sm">Xóa</a>
            </td>
          </tr>
          <tr>
            <td class="text-center">3</td>
            <td class="text-center">Nguyễn Văn C</td>
            <td class="text-center">
              <a href="mailto:sH4l9@example.com">sH4l9@example.com</a>
            </td>
            <td class="text-center">0123456789</td>
            <td class="text-center">Hà Nội</td>
            <td class="text-center">user</td>
            <td class="text-center text-danger fw-bold">ofline</td>
            <td class="text-center">
              <a href="javascript:" class="btn btn-primary btn-sm">Sửa</a> 
              <a href="javascript:" class="btn btn-info btn-sm">xem</a>
              <a href="javascript:" class="btn btn-danger btn-sm">Xóa</a>
            </td>
          </tr>
          <tr>
            <td class="text-center">4</td>
            <td class="text-center">Nguyễn Văn D</td>
            <td class="text-center">
              <a href="mailto:
              sH4l9@example.com">sH4l9@example.com</a>
            </td>
            <td class="text-center">0123456789</td>
            <td class="text-center">Hà Nội</td>
            <td class="text-center">user</td>
            <td class="text-center text-danger fw-bold">no active</td>
            <td class="text-center">
              <a href="javascript:" class="btn btn-primary btn-sm">Sửa</a> <a href="javascript:" class="btn btn-info btn-sm">xem</a>
              <a href="javascript:" class="btn btn-danger btn-sm">Xóa</a>
            </td>
          </tr>
          <tr>
            <td class="text-center">5</td>
            <td class="text-center">Nguyễn Văn E</td>
            <td class="text-center">
              <a href="mailto:sH4l9@example.com">sH4l9@example.com</a>
            </td>
            <td class="text-center">0123456789</td>
            <td class="text-center">Hà Nội</td>
            <td class="text-center">user</td>
            <td class="text-center text-success fw-bold">active</td>
            <td class="text-center">
              <a href="javascript:" class="btn btn-primary btn-sm">Sửa</a> <a href="javascript:" class="btn btn-info btn-sm">xem</a>
              <a href="javascript:" class="btn btn-danger btn-sm">Xóa</a>
            </td>
          </tr>
          <tr>
            <td class="text-center">5</td>
            <td class="text-center">Nguyễn Văn E</td>
            <td class="text-center">
              <a href="mailto:sH4l9@example.com">sH4l9@example.com</a>
            </td>
            <td class="text-center">0123456789</td>
            <td class="text-center">Hà Nội</td>
            <td class="text-center">user</td>
            <td class="text-center text-success fw-bold">active</td>
            <td class="text-center">
              <a href="javascript:" class="btn btn-primary btn-sm">Sửa</a> <a href="javascript:" class="btn btn-info btn-sm">xem</a>
              <a href="javascript:" class="btn btn-danger btn-sm">Xóa</a>
            </td>
          </tr>
          <tr>
            <td class="text-center">5</td>
            <td class="text-center">Nguyễn Văn E</td>
            <td class="text-center">
              <a href="mailto:sH4l9@example.com">sH4l9@example.com</a>
            </td>
            <td class="text-center">0123456789</td>
            <td class="text-center">Hà Nội</td>
            <td class="text-center">user</td>
            <td class="text-center text-success fw-bold">active</td>
            <td class="text-center">
              <a href="javascript:" class="btn btn-primary btn-sm">Sửa</a> <a href="javascript:" class="btn btn-info btn-sm">xem</a>
              <a href="javascript:" class="btn btn-danger btn-sm">Xóa</a>
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
   
      <div class="col-md-4">
                    <!-- USERS LIST -->
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Người dùng mới</h3>
                        <div class="card-tools">
                          <span class="badge text-bg-danger"> 8 Người dùng</span>
                          <button
                            type="button"
                            class="btn btn-tool"
                            data-lte-toggle="card-collapse"
                          >
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <div class="row text-center m-1">
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user1-128x128.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              Alexander Pierce
                            </a>
                            <div class="fs-8">Today</div>
                          </div>
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user1-128x128.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              Norman
                            </a>
                            <div class="fs-8">Yesterday</div>
                          </div>
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user7-128x128.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              Jane
                            </a>
                            <div class="fs-8">12 Jan</div>
                          </div>
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user6-128x128.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              John
                            </a>
                            <div class="fs-8">12 Jan</div>
                          </div>
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user2-160x160.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              Alexander
                            </a>
                            <div class="fs-8">13 Jan</div>
                          </div>
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user5-128x128.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              Sarah
                            </a>
                            <div class="fs-8">14 Jan</div>
                          </div>
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user4-128x128.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              Nora
                            </a>
                            <div class="fs-8">15 Jan</div>
                          </div>
                          <div class="col-3 p-2">
                            <img
                              class="img-fluid rounded-circle"
                              src="../../dist/assets/img/user3-128x128.jpg"
                              alt="User Image"
                            />
                            <a
                              class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
                              href="#"
                            >
                              Nadia
                            </a>
                            <div class="fs-8">15 Jan</div>
                          </div>
                        </div>
                        <!-- /.users-list -->
                      </div>
                      <!-- /.card-body -->
                     
                    </div>
                    <!-- /.card -->
                  </div>
  </div>
 </div>
</div>
@endsection