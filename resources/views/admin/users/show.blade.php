@extends('admin.layouts.AdminLayouts')

@section('title')
    <title>Chi tiết người dùng</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <h1>Chi tiết người dùng</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- <div class="col-md-3 text-center">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="img-fluid rounded-circle" alt="User Image" style="width: 128px; height: 128px;">
                        @else
                            <img src="{{ asset('dist/assets/img/user1-128x128.jpg') }}" class="img-fluid rounded-circle" alt="User Image" style="width: 128px; height: 128px;">
                        @endif
                    </div> -->
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h5 class="card-title"><strong>Họ tên:</strong> {{ $user->name }}</h5>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="card-text"><strong>Số điện thoại:</strong> {{ $user->phone_number ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="card-text"><strong>Địa chỉ:</strong> {{ $user->address ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="card-text"><strong>Quyền:</strong> {{ $user->role ? $user->role->name : 'user' }}</p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="card-text"><strong>Trạng thái:</strong> 
                                <span class="{{ $user->status == 'active' ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ $user->status }}
                                </span>
                            </p>
                        </div>
                        <div class="col-12 mb-2">
                            <p class="card-text"><strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mt-3">Chỉnh sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection