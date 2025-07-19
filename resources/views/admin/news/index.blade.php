@extends('admin.layouts.AdminLayouts')
@section('title-page')
    <h3>Danh sách Bài viết</h3>
@endsection
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-info text-white fw-bold">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <form class="d-flex" method="GET" action="{{ route('admin.news.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Tìm kiếm theo tiêu đề, slug...">
                            <button class="btn btn-light text-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('admin.news.index') }}">
                            <select name="status" onchange="this.form.submit()" class="form-select text-center">
                                <option value="">Tất cả trạng thái</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('admin.news.create') }}" class="btn btn-success text-white"><i class="bi bi-plus-circle me-1"></i> Thêm mới</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
                        <strong>Thành công!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <table class="table table-bordered table-striped table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Ngày đăng</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    {{-- ĐÃ SỬA --}}
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="img-fluid" style="max-width: 80px; height: auto;">
                                </td>
                                <td class="text-start">{{ $item->title }}</td>
                                <td>{{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : 'Chưa đăng' }}</td>
                                <td>
                                    <span class="badge {{ $item->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $item->status ? 'Hoạt động' : 'Tạm dừng' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.news.toggleStatus', $item->id) }}" method="POST" class="me-1" onsubmit="return confirm('Bạn có chắc chắn muốn đổi trạng thái bài viết này?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm text-white {{ $item->status ? 'bg-danger' : 'bg-success' }}">
                                                <i class="bi {{ $item->status ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                                {{ $item->status ? 'Dừng' : 'Kích hoạt' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa (vào thùng rác)?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Chưa có bài viết nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $news->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection