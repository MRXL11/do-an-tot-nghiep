@extends('admin.layouts.AdminLayouts')

@section('title-page')
    <h3>Danh sách Slide</h3>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        {{-- Các thông báo thành công/lỗi --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
                <strong>Thành công!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header bg-info text-white fw-bold">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <form class="d-flex" method="GET" action="{{ route('admin.slides.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Tìm kiếm theo tiêu đề...">
                            <button class="btn btn-light text-primary" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <form method="GET" action="{{ route('admin.slides.index') }}">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tạm dừng</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('admin.slides.create') }}" class="btn btn-success text-white"><i class="bi bi-plus-circle me-1"></i> Thêm</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Thứ tự</th>
                            <th>Bài viết liên kết</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slides as $slide)
                            <tr>
                                <td>{{ $slide->id }}</td>
                                <td>
                                    {{-- SỬA LẠI CÁCH HIỂN THỊ ẢNH --}}
                                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" width="150">
                                </td>
                                <td>{{ $slide->title }}</td>
                                <td>{{ $slide->order }}</td>
                                <td>{{ $slide->news?->title ?? 'Không có' }}</td>
                                <td>
                                    {{-- SỬA LẠI LOGIC HIỂN THỊ TRẠNG THÁI --}}
                                    <span class="badge {{ $slide->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $slide->status ? 'Hoạt động' : 'Tạm dừng' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.slides.edit', $slide->id) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('admin.slides.toggleStatus', $slide->id) }}" method="POST" class="me-1">
                                            @csrf
                                            @method('PATCH')
                                            {{-- SỬA LẠI LOGIC NÚT CHUYỂN TRẠNG THÁI --}}
                                            <button type="submit" class="btn btn-sm text-white {{ $slide->status ? 'bg-secondary' : 'bg-success' }}" title="{{ $slide->status ? 'Tạm dừng' : 'Kích hoạt' }}">
                                                <i class="bi {{ $slide->status ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Chuyển vào thùng rác?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Không tìm thấy slide nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $slides->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection