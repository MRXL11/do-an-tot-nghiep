@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Quản lý Màu sắc & Kích thước</h3>
@endsection

@section('content')
<div class="container-fluid">
    {{-- Hiển thị thông báo --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
             @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-palette-fill me-2"></i>Quản lý Màu sắc</h5>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addColorModal">
                        <i class="bi bi-plus-circle"></i> Thêm màu
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Tên màu</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($colors as $color)
                                <tr>
                                    <td class="text-center">{{ $color->id }}</td>
                                    <td>{{ $color->value }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editValueModal" data-id="{{ $color->id }}" data-value="{{ $color->value }}">
                                            <i class="bi bi-pencil-square"></i> Sửa
                                        </button>
                                        <form class="d-inline" action="{{ route('admin.attributes.destroyValue', $color->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa màu này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">Chưa có màu sắc nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">{{ $colors->appends(request()->except('colors_page'))->links() }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-rulers me-2"></i>Quản lý Kích thước</h5>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addSizeModal">
                        <i class="bi bi-plus-circle"></i> Thêm size
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Tên size</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                             @forelse ($sizes as $size)
                                <tr>
                                    <td class="text-center">{{ $size->id }}</td>
                                    <td>{{ $size->value }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editValueModal" data-id="{{ $size->id }}" data-value="{{ $size->value }}">
                                            <i class="bi bi-pencil-square"></i> Sửa
                                        </button>
                                        <form class="d-inline" action="{{ route('admin.attributes.destroyValue', $size->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa size này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">Chưa có kích thước nào.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">{{ $sizes->appends(request()->except('sizes_page'))->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addColorModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.attributes.storeValue') }}" method="POST">
                    @csrf
                    <input type="hidden" name="attribute_id" value="{{ $colorAttribute->id }}">
                    <div class="modal-header"><h5 class="modal-title">Thêm màu sắc mới</h5></div>
                    <div class="modal-body">
                        <label for="color_value" class="form-label">Tên màu</label>
                        <input type="text" name="value" id="color_value" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSizeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.attributes.storeValue') }}" method="POST">
                    @csrf
                    <input type="hidden" name="attribute_id" value="{{ $sizeAttribute->id }}">
                    <div class="modal-header"><h5 class="modal-title">Thêm kích thước mới</h5></div>
                    <div class="modal-body">
                        <label for="size_value" class="form-label">Tên size</label>
                        <input type="text" name="value" id="size_value" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editValueModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editValueForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">Chỉnh sửa giá trị</h5></div>
                    <div class="modal-body">
                        <label for="edit_value" class="form-label">Tên giá trị</label>
                        <input type="text" name="value" id="edit_value" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-warning">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script để truyền dữ liệu vào modal chỉnh sửa
    const editValueModal = document.getElementById('editValueModal');
    editValueModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const valueId = button.getAttribute('data-id');
        const valueName = button.getAttribute('data-value');

        const form = editValueModal.querySelector('#editValueForm');
        const input = editValueModal.querySelector('#edit_value');
        
        // Cập nhật action của form
        let action = "{{ route('admin.attributes.updateValue', ':id') }}";
        action = action.replace(':id', valueId);
        form.setAttribute('action', action);

        // Điền giá trị vào input
        input.value = valueName;
    });
</script>
@endsection