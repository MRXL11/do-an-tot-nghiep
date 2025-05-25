  @extends('admin.layouts.AdminLayouts')

    @section('title')
    <title>Quản lý người dùng</title>
    @endsection
    @section('content')
    <div class="container-fluid">
    <div class="col-lg-12">
        <div class="row g-4 mb-4">
        <div class="col-md-8">
            {{-- phần này là tìm kiếm --}}
        <div class="card-header bg-info text-white fw-bold">
    <div class="row align-items-center">
        <!-- Tìm kiếm -->
        <div class="col-md-10">
            <form class="d-flex">
                <input type="text" class="form-control me-2" placeholder="Tìm kiếm Brand...">
                <button class="btn btn-light text-primary " type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <!-- Nút thêm -->
        <div class="col-md-2 text-end">
            <button class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Thêm
            </button>
        </div>
    </div>
</div>
        {{-- kết thúc tìm kiếm --}}
        <table class="table table-bordered table-striped table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên thương hiệu</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Ngày hợp tác</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Luôn vui tươi</td>
                    <td><img src="https://tse2.mm.bing.net/th?id=OIP.b8uaOsL-9-ALdfegF3KmaQHaEV&pid=Api&P=0&h=180" alt="Hình ảnh" height="50px" height="50px"></td>
                    <td>Hoạt động</td>
                    <td>2023-01-01</td>
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
                    <td>1</td>
                    <td>Gucci</td>
                    <td><img src="https://tse3.mm.bing.net/th?id=OIP.QS54h0YWrBYIfadQ6zYl5wHaEx&pid=Api&P=0&h=180" alt="Hình ảnh" height="50px" height="50px"></td>
                    <td>Hoạt động</td>
                    <td>2023-01-01</td>
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
                    <td>1</td>
                    <td>Chà neo</td>
                    <td><img src="https://tse1.mm.bing.net/th?id=OIP.EXftwRotrWR36lLNevdVzgHaFr&pid=Api&P=0&h=180" alt="Hình ảnh" height="50px" height="50px"></td>
                    <td>Hoạt động</td>
                    <td>2023-01-01</td>
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
                    <td>1</td>
                    <td>Chà neo</td>
                    <td><img src="https://tse3.mm.bing.net/th?id=OIP.ed9tszh10Dk8FiC2ThB3DQHaEK&pid=Api&P=0&h=180" alt="Hình ảnh" height="50px" height="50px"></td>
                    <td>Hoạt động</td>
                    <td>2023-01-01</td>
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
        <!-- brand LIST -->
        <div class="card">
            <div class="card-header mb-2">
         <strong><h3 class="card-title">TOP Nhãn hàng bán chạy</h3></strong>  
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
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
                <div class="row text-center g-2 mb-2">

                    <!-- Nhãn hàng 1 -->
                    <div class="col-3 d-flex flex-column align-items-center">
                    <img class="img-fluid rounded-circle mb-1"
                        src="https://tse4.mm.bing.net/th?id=OIP.W3JJJ-PKZao4_8GoJMHDQQHaEK&pid=Api&P=0&h=180"
                        alt="Guucci" style="width: 60px; height: 60px; object-fit: cover;" />
                    <a class="fw-semibold text-secondary text-center text-truncate d-block w-100" href="#" title="Guucci"
                        style="font-size: 0.85rem;">
                        Guucci
                    </a>
                    </div>

                    <!-- Nhãn hàng 2 -->
                    <div class="col-3 d-flex flex-column align-items-center">
                    <img class="img-fluid rounded-circle mb-1"
                        src="https://tse2.mm.bing.net/th?id=OIP.z771H4PH1jo6Mlv3Q3vjGAHaHa&pid=Api&P=0&h=180"
                        alt="Balensikaka" style="width: 60px; height: 60px; object-fit: cover;" />
                    <a class="fw-semibold text-secondary text-center text-truncate d-block w-100" href="#" title="Balensikaka"
                        style="font-size: 0.85rem;">
                        Balensikaka
                    </a>
                    </div>

                    <!-- Nhãn hàng 3 -->
                    <div class="col-3 d-flex flex-column align-items-center">
                    <img class="img-fluid rounded-circle mb-1"
                        src="https://tse2.mm.bing.net/th?id=OIP.pTHh0ycVTwZZkmrni-HzUwHaC2&pid=Api&P=0&h=180"
                        alt="Luôn vui tươi" style="width: 60px; height: 60px; object-fit: cover;" />
                    <a class="fw-semibold text-secondary text-center text-truncate d-block w-100" href="#" title="Luôn vui tươi"
                        style="font-size: 0.85rem;">
                        Luôn vui tươi
                    </a>
                    </div>

                    <!-- Nhãn hàng 4 -->
                    <div class="col-3 d-flex flex-column align-items-center">
                    <img class="img-fluid rounded-circle mb-1"
                        src="https://tse2.mm.bing.net/th?id=OIP.coKI0-WmrVVZznoBnS5jogHaEK&pid=Api&P=0&h=180"
                        alt="JD" style="width: 60px; height: 60px; object-fit: cover;" />
                    <a class="fw-semibold text-secondary text-center text-truncate d-block w-100" href="#" title="JD"
                        style="font-size: 0.85rem;">
                        JD
                    </a>
                    </div>

                    <!-- Nhãn hàng 5 -->
                    <div class="col-3 d-flex flex-column align-items-center">
                    <img class="img-fluid rounded-circle mb-1"
                        src="https://tse2.mm.bing.net/th?id=OIP.WUBQz0ddOsL-RS2RhfeJOgHaEK&pid=Api&P=0&h=180"
                        alt="Adidass" style="width: 60px; height: 60px; object-fit: cover;" />
                    <a class="fw-semibold text-secondary text-center text-truncate d-block w-100" href="#" title="Adidass"
                        style="font-size: 0.85rem;">
                        Adidass
                    </a>
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col-md-4 -->

    </div>
    </div>
 @endsection