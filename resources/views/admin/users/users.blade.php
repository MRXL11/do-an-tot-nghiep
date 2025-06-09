@extends('admin.layouts.AdminLayouts')

@section('title')
    <title>Quản lý người dùng</title>
@endsection

@section('content')

<style>
    table {
        table-layout: fixed;
        width: 100%;
    }
    th, td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: middle;
    }
</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row g-4 mb-4">
            <div class="col-12"> <!-- Sửa col-md-8 thành col-12 -->
                <div class="d-flex mb-3">
                    <form class="d-flex flex-grow-1 me-2" role="search" action="{{ route('admin.users.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light" id="search-icon"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Nhập tên hoặc email để tìm kiếm" aria-label="Tìm kiếm" aria-describedby="search-icon" name="search" value="{{ $search }}">
                            <button class="btn btn-primary" type="submit">Tìm</button>
                        </div>
                    </form>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Thêm</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div style="overflow-x:auto;">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="text-center">STT</th>
                                <th style="width: 15%;" class="text-center">Họ tên</th>
                                <th style="width: 20%;" class="text-center">Email</th>
                                <th style="width: 10%;" class="text-center">SĐT</th>
                                <th style="width: 20%;" class="text-center">Địa chỉ</th>
                                <th style="width: 15%;" class="text-center">Ngày tạo</th>
                                <th style="width: 10%;" class="text-center">Quyền</th>
                                <th style="width: 10%;" class="text-center">Trạng thái</th>
                                <th style="width: 15%;" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="text-center" title="{{ $users->firstItem() + $index }}">{{ $users->firstItem() + $index }}</td>
                                    <td class="text-center" title="{{ $user->name }}">{{ $user->name }}</td>
                                    <td class="text-center" title="{{ $user->email }}"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    <td class="text-center" title="{{ $user->phone_number }}">{{ $user->phone_number }}</td>
                                    <td class="text-center" title="{{ $user->address }}">{{ $user->address }}</td>
                                    <td class="text-center" title="{{ $user->created_at }}">{{ $user->created_at }}</td>

                                    <td class="text-center" title="{{ $user->role ? $user->role->name : 'user' }}">
                                        @php $roleName = $user->role ? $user->role->name : 'user'; @endphp
                                        {{ $roleName == 'admin' ? 'Quản trị viên' : 'Khách hàng' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge 
                                            {{ $user->status == 'active' ? 'bg-success' : ($user->status == 'inactive' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ 
                                                $user->status == 'active' ? 'Hoạt động' : 
                                                ($user->status == 'inactive' ? 'Ngừng hoạt động' : 'Bị cấm') 
                                            }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($user->trashed())
                                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Khôi phục người dùng này?')" title="Khôi phục người dùng">Khôi phục</button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa người dùng">Sửa</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')" title="Xóa người dùng">Xóa</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center">Không có người dùng nào.</td></tr> <!-- colspan=9 vì 9 cột -->
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
