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

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th class="text-center">Họ tên</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">SĐT</th>
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
                                <td class="text-center fixed-width-name">{{ $user->name }}</td>
                                <td class="text-center fixed-width-email"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                <td class="text-center">{{ $user->phone_number }}</td>
                                <td class="text-center fixed-width-address">{{ $user->address }}</td>

                                <td class="text-center">
                                    @php $roleName = $user->role ? $user->role->name : 'user'; @endphp
                                    {{ $roleName == 'admin' ? 'Quản trị viên' : ($roleName == 'staff' ? 'Nhân viên' : 'Khách hàng') }}
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
                                      <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm" title="Xem chi tiết người dùng">Xem</a>
                                      <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')" title="Xóa người dùng">Xóa</button>
                                      </form>
                                  @endif
                              </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Không có người dùng nào.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $users->links() }}
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Người dùng mới</h3>
                        <div class="card-tools">
                            <span class="badge text-bg-danger">Người dùng</span>
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row text-center g-3 m-2">
                            @forelse($newUsers as $newUser)
                                <div class="col-4">
                                    <img class="img-fluid rounded-circle shadow-sm mb-2" 
                                        style="width: 80px; height: 80px; object-fit: cover;" 
                                        src="{{ $newUser->avatar ? asset('storage/' . $newUser->avatar) : asset('dist/assets/img/user1-128x128.jpg') }}" 
                                        alt="User Image">
                                    <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="{{ route('admin.users.show', $user) }}">{{ $newUser->name }}</a>
                                    <div class="fs-8">{{ $newUser->created_at->format('d M') }}</div>
                                </div>
                            @empty
                                <div class="col-12 p-2"><p class="text-center">Chưa có người dùng mới.</p></div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .table td,
    .table th {
        vertical-align: middle;
        word-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    td.fixed-width-name {
        max-width: 120px;
    }

    td.fixed-width-email {
        max-width: 150px;
    }

    td.fixed-width-address {
        max-width: 200px;
    }

    .table td, .table th {
        overflow-wrap: break-word;
    }
</style>
@endsection
