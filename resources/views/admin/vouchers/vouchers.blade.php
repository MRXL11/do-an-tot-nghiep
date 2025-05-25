@extends('admin.layouts.AdminLayouts')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        
    <div class="card shadow">
        {{-- phần này là tìm kiếm --}}
        <div class="card-header text-white fw-bold">
    <div class="row align-items-center">
        <!-- Tìm kiếm -->
        <div class="col-md-10">
            <form class="d-flex">
                <input type="text" class="form-control me-2" placeholder="Tìm kiếm mã giảm giá...">
                <button class="btn btn-light text-primary " type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <!-- Nút thêm -->
        <div class="col-md-2 text-end">
            <button class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Thêm Voucher
            </button>
        </div>
    </div>
</div>
        {{-- kết thúc tìm kiếm --}}
        <div class="card-body p-0">
            <table class="table table-hover table-bordered align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Mã Voucher</th>
                        <th>Phần trăm giảm</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th width="237">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>SUMMER20</td>
                        <td>20%</td>
                        <td>2025-06-01</td>
                        <td>2025-06-30</td>
                        <td><span class="badge bg-success">ACtive</span></td>
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
                        <td>2</td>
                        <td>NEWYEAR50</td>
                        <td>50%</td>
                        <td>2025-01-01</td>
                        <td>2025-01-15</td>
                        <td><span class="badge bg-danger">Hết hạn</span></td>
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
                        <td>3</td>
                        <td>FREESHIP</td>
                        <td>100%</td>
                        <td>2025-05-01</td>
                        <td>2025-12-31</td>
                        <td><span class="badge bg-warning">Sắp hết hạn</span></td>
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
                        <td>3</td>
                        <td>FREESHIP</td>
                        <td>100%</td>
                        <td>2025-05-01</td>
                        <td>2025-12-31</td>
                        <td><span class="badge bg-warning">Sắp hết hạn</span></td>
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
                        <td>3</td>
                        <td>FREESHIP</td>
                        <td>100%</td>
                        <td>2025-05-01</td>
                        <td>2025-12-31</td>
                        <td><span class="badge bg-warning">Sắp hết hạn</span></td>
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
                        <td>6</td>
                        <td>SUMMER20</td>
                        <td>20%</td>
                        <td>2025-06-01</td>
                        <td>2025-06-30</td>
                        <td><span class="badge bg-success">ACtive</span></td>
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
            {{-- đây là phân trang paginate --}}
            <div class="d-flex justify-content-center mt-3">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>  
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                </ul>
            </div>
            {{-- kết thúc phân trang --}}
        </div>
    </div>
    </div>
   

</div>
@endsection