@extends('admin.layouts.AdminLayouts')

@section('title')
    <title>Quản lý người dùng</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row g-4 mb-4">
            <div class="col-md-8">
      
                <div class="d-flex mb-3">
    {{-- Form tìm kiếm --}}
    <form class="d-flex flex-grow-1 me-2" role="search" action="{{ route('admin.users.index') }}" method="GET">
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
                value="{{ $search }}"
            >
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    {{-- Nút thêm người dùng --}}
    <a href="{{ route('admin.users.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Thêm
    </a>
</div>


                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

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
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center">{{ $users->firstItem() + $index }}</td>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">
                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </td>
                                <td class="text-center">{{ $user->phone_number ?? 'N/A' }}</td>
                                <td class="text-center">N/A</td> <!-- Migration không có trường address, bạn có thể thêm nếu cần -->
                                <td class="text-center">{{ $user->role ? $user->role->name : 'user' }}</td>
                                <td class="text-center {{ $user->status == 'active' ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ $user->status }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">Sửa</a>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">Xem</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có người dùng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Phân trang --}}
                  {{ $users->links() }}
                {{-- Kết thúc phân trang --}}
            </div>

            <div class="col-md-4">
                <!-- USERS LIST -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Người dùng mới</h3>
                        <div class="card-tools">
                            <span class="badge text-bg-danger"> Người dùng</span>
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
                            @forelse($newUsers as $newUser)
    <div class="col-3 p-2">
        <img
            class="img-fluid rounded-circle"
            src="{{ asset('dist/assets/img/user1-128x128.jpg') }}"
            alt="User Image"
        />
        <a
            class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0"
            href="#"
        >
            {{ $newUser->name }}
        </a>
        <div class="fs-8">{{ $newUser->created_at->format('d M') }}</div>
    </div>
@empty
    <div class="col-12 p-2">
        <p class="text-center">Chưa có người dùng mới.</p>
    </div>
@endforelse

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>
@endsection