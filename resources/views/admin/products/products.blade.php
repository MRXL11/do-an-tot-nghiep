@extends('admin.layouts.AdminLayouts')

@section('title')
  <title>Quản lý sản phẩm</title>
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row g-4 mb-4">
    <div class="col-md-8">
      {{-- tìm kiếm ở đây --}}
      <form class="row gx-2 align-items-center mb-2" action="/timkiem" method="GET">
  <!-- Ô tìm kiếm -->
  <div class="col-auto">
    <div class="input-group">
      <span class="input-group-text bg-light" id="search-icon">
        <i class="bi bi-search"></i>
      </span>
      <input 
        type="text" 
        class="form-control form-group-lg" 
        placeholder="Tìm kiếm sản phẩm..." 
        aria-label="Tìm kiếm" 
        aria-describedby="search-icon" 
        name="q"
        value="{{ request('q') }}"
      >
    </div>
  </div>

  <!-- Select danh mục -->
  <div class="col-auto">
    <select class="form-select" name="category">
      <option value="">--Tất cả danh mục--</option>
      <option value="1" {{ request('category') == 1 ? 'selected' : '' }}>Áo khoác</option>
      <option value="2" {{ request('category') == 2 ? 'selected' : '' }}>Áo len</option>
      <option value="3" {{ request('category') == 3 ? 'selected' : '' }}>Áo phông</option>
      <option value="4" {{ request('category') == 4 ? 'selected' : '' }}>Quần</option>
    </select>
  </div>
  <!-- Select trang thái -->
  <div class="col-auto">
    <select class="form-select" name="category">
      <option value="">-- Trang thái --</option>
      <option value="1" {{ request('category') == 1 ? 'selected' : '' }}>Hết hàng</option>
      <option value="2" {{ request('category') == 2 ? 'selected' : '' }}>Còn Hàng</option>
      <option value="3" {{ request('category') == 3 ? 'selected' : '' }}>Bán chạy</option>
      <option value="4" {{ request('category') == 3 ? 'selected' : '' }}>Đang giảm giá</option>
      <option value="5" {{ request('category') == 3 ? 'selected' : '' }}>Mới nhất</option>
    </select>
  </div>
  <!-- Select  -->
  <div class="col-auto">
    <select class="form-select" name="category">
      <option value="">--Quan tâm--</option>
      <option value="1" {{ request('category') == 1 ? 'selected' : '' }}>Yêu thích</option>
      <option value="2" {{ request('category') == 2 ? 'selected' : '' }}>Giỏ hàng</option>
      <option value="3" {{ request('category') == 3 ? 'selected' : '' }}>Xem nhiều</option>
    </select>
  </div>

  <!-- Nút submit -->
  <div class="col-auto ">
    <button class="btn  btn-primary" type="submit">
      Tìm kiếm
    </button>
  </div>
</form>
      {{-- kết thúc tìm kiếm --}} 
      <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Tên sản phẩm</th>
                <th class="text-center">Hình ảnh</th>
                <th class="text-center">Số lượng nhập</th>
                <th class="text-center">Số lượng bán</th>
                <th class="text-center">Giá bán</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">Sản phẩm 1</td>
                <td class="text-center"><img src="{{asset('dist/assets/img/prod-1.jpg')}}" alt="Product Image" class="img-size-50"/></td>
                <td class="text-center">100</td>
                <td class="text-center">50</td>
                <td class="text-center">$100</td>
                <td class="text-center">Còn hàng</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-primary">Chi tiết</button>
                    <button type="button" class="btn btn-sm btn-warning">Sửa</button>
                    <button type="button" class="btn btn-sm btn-danger">Xóa</button>    

                </td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td class="text-center">Sản phẩm 2</td>
                <td class="text-center"><img src="{{asset('dist/assets/img/prod-2.jpg')}}" alt="Product Image" class="img-size-50"/></td>
                <td class="text-center">200</td>
                <td class="text-center">100</td>
                <td class="text-center">$200</td>
                <td class="text-center">Còn hàng</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-primary">Chi tiết</button>
                    <button type="button" class="btn btn-sm btn-outline-warning">Sửa</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Xóa</button>    

                </td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td class="text-center">Sản phẩm 3</td>
                <td class="text-center"><img src="{{asset('dist/assets/img/prod-3.jpg')}}" alt="Product Image" class="img-size-50"/></td>
                <td class="text-center">300</td>
                <td class="text-center">150</td>
                <td class="text-center">$300</td>
                <td class="text-center">Còn hàng</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-primary">Chi tiết</button>
                    <button type="button" class="btn btn-sm btn-outline-warning">Sửa</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Xóa</button>    

                </td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td class="text-center">Sản phẩm 4</td>
                <td class="text-center"><img src="{{asset('dist/assets/img/prod-4.jpg')}}" alt="Product Image" class="img-size-50"/></td>
                <td class="text-center">400</td>
                <td class="text-center">200</td>
                <td class="text-center">$400</td>
                <td class="text-center">Còn hàng</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-primary">Chi tiết</button>
                    <button type="button" class="btn btn-sm btn-outline-warning">Sửa</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Xóa</button>    

                </td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td class="text-center">Sản phẩm 5</td>
                <td class="text-center"><img src="{{asset('dist/assets/img/prod-5.jpg')}}" alt="Product Image" class="img-size-50"/></td>
                <td class="text-center">500</td>
                <td class="text-center">250</td>
                <td class="text-center">$500</td>
                <td class="text-center">Còn hàng</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-primary">Chi tiết</button>
                    <button type="button" class="btn btn-sm btn-outline-warning">Sửa</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Xóa</button>    

                </td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td class="text-center">Sản phẩm 6</td>
                <td class="text-center"><img src="{{asset('dist/assets/img/prod-2.jpg')}}" alt="Product Image" class="img-size-50"/></td>
                <td class="text-center">600</td>
                <td class="text-center">300</td>
                <td class="text-center">$600</td>
                <td class="text-center">Còn hàng</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-primary">Chi tiết</button>
                    <button type="button" class="btn btn-sm btn-outline-warning">Sửa</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Xóa</button>    

                </td>
            </tr>
            <tr>
                <td class="text-center">7</td>
                <td class="text-center">Sản phẩm 7</td>
                <td class="text-center"><img src="{{asset('dist/assets/img/prod-1.jpg')}}" alt="Product Image" class="img-size-50"/></td>
                <td class="text-center">700</td>
                <td class="text-center">350</td>
                <td class="text-center">$700</td>
                <td class="text-center">Còn hàng</td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-outline-primary">Chi tiết</button>
                    <button type="button" class="btn btn-sm btn-outline-warning">Sửa</button>
                    <button type="button" class="btn btn-sm btn-outline-danger">Xóa</button>    

                </td>
            </tr>
            <tr>
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
              <!-- PRODUCT LIST -->
                <div class="card">
                  <div class="card-header">
                    <button class="btn btn-sm btn-block btn-success mb-2">Thêm sản phẩm</button><br>
                    <h3 class="card-title">Các sản phẩm đã thêm gần đây</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-sm btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-tool" data-lte-toggle="card-remove">
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <div class="px-2">
                      <div class="d-flex border-top py-2 px-1">
                        <div class="col-2">
                          <img
                            src="../../dist/assets/img/default-150x150.png"
                            alt="Product Image"
                            class="img-size-50"
                          />
                        </div>
                        <div class="col-10">
                          <a href="javascript:void(0)" class="fw-bold">
                            Samsung TV
                            <span class="badge text-bg-warning float-end"> $1800 </span>
                          </a>
                          <div class="text-truncate">Samsung 32" 1080p 60Hz LED Smart HDTV.</div>
                        </div>
                      </div>
                      <!-- /.item -->
                      <div class="d-flex border-top py-2 px-1">
                        <div class="col-2">
                          <img
                            src="../../dist/assets/img/default-150x150.png"
                            alt="Product Image"
                            class="img-size-50"
                          />
                        </div>
                        <div class="col-10">
                          <a href="javascript:void(0)" class="fw-bold">
                            Bicycle
                            <span class="badge text-bg-info float-end"> $700 </span>
                          </a>
                          <div class="text-truncate">
                            26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                          </div>
                        </div>
                      </div>
                      <!-- /.item -->
                      <div class="d-flex border-top py-2 px-1">
                        <div class="col-2">
                          <img
                            src="../../dist/assets/img/default-150x150.png"
                            alt="Product Image"
                            class="img-size-50"
                          />
                        </div>
                        <div class="col-10">
                          <a href="javascript:void(0)" class="fw-bold">
                            Xbox One
                            <span class="badge text-bg-danger float-end"> $350 </span>
                          </a>
                          <div class="text-truncate">
                            Xbox One Console Bundle with Halo Master Chief Collection.
                          </div>
                        </div>
                      </div>
                      <!-- /.item -->
                      <div class="d-flex border-top py-2 px-1">
                        <div class="col-2">
                          <img
                            src="../../dist/assets/img/default-150x150.png"
                            alt="Product Image"
                            class="img-size-50"
                          />
                        </div>
                        <div class="col-10">
                          <a href="javascript:void(0)" class="fw-bold">
                            PlayStation 4
                            <span class="badge text-bg-success float-end"> $399 </span>
                          </a>
                          <div class="text-truncate">PlayStation 4 500GB Console (PS4)</div>
                        </div>
                      </div>
                      <!-- /.item -->
                      <div class="d-flex border-top py-2 px-1">
                        <div class="col-2">
                          <img
                            src="../../dist/assets/img/default-150x150.png"
                            alt="Product Image"
                            class="img-size-50"
                          />
                        </div>
                        <div class="col-10">
                          <a href="javascript:void(0)" class="fw-bold">
                            PlayStation 4
                            <span class="badge text-bg-success float-end"> $399 </span>
                          </a>
                          <div class="text-truncate">PlayStation 4 500GB Console (PS4)</div>
                        </div>
                      </div>
                      <!-- /.item -->
                    </div>
                  </div>
                  
                </div>
                <!-- /.card -->       
    </div>
  </div>
 </div>
</div>
@endsection