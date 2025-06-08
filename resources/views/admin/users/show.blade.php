@extends('admin.layouts.AdminLayouts')

@section('title')
    <title>Chi tiết người dùng</title>
@endsection

@section('content')
<style>
    .user-info-container {
        margin: 0 auto;
        width: 60%;
    }

    .user-info-row {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed #e0e0e0;
    }

    .user-info-label {
        font-weight: bold;
        font-size: 24px;
        width: 35%;
        text-align: right;
        padding-right: 20px;
        white-space: nowrap;
    }

    .user-info-value {
        font-size: 18px;
        color: #6c757d; /* text-secondary */
        width: 65%;
        text-align: left;
    }

    .avatar-image {
        width: 128px;
        height: 128px;
        border-radius: 50%;
        object-fit: cover;
    }

    .btn-group-left {
        display: flex;
        justify-content: flex-start;
        gap: 12px;
    }
</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <h1 class="text-center mb-4">Chi tiết người dùng</h1>
        <div class="card">
            <div class="card-body">
                {{-- Thông tin --}}
                <div class="user-info-container">
                    {{-- Avatar --}}
                    <div class="user-info-row">
                        <div class="user-info-label">Avatar:</div>
                        <div class="user-info-value">
                            @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                <img id="preview_avatar" src="{{ asset('storage/' . $user->avatar) }}" alt="User Image" class="avatar-image">
                            @else
                                <img id="preview_avatar" src="{{ asset('dist/assets/img/user1-128x128.jpg') }}" alt="User Image" class="avatar-image">
                            @endif
                        </div>
                    </div>

                    {{-- Các thông tin khác --}}
                    <div class="user-info-row">
                        <div class="user-info-label">Tên:</div>
                        <div class="user-info-value">{{ $user->name }}</div>
                    </div>
                    <div class="user-info-row">
                        <div class="user-info-label">Email:</div>
                        <div class="user-info-value">{{ $user->email }}</div>
                    </div>
                    <div class="user-info-row">
                        <div class="user-info-label">Số điện thoại:</div>
                        <div class="user-info-value">{{ $user->phone_number ?? 'N/A' }}</div>
                    </div>
                    <div class="user-info-row">
                        <div class="user-info-label">Địa chỉ:</div>
                        <div class="user-info-value">{{ $user->address ?? 'N/A' }}</div>
                    </div>
                    <div class="user-info-row">
                        <div class="user-info-label">Quyền:</div>
                        <div class="user-info-value">{{ $user->role ? $user->role->name : 'user' }}</div>
                    </div>
                    <div class="user-info-row">
                        <div class="user-info-label">Trạng thái:</div>
                        <div class="user-info-value">
                            <span class="{{ $user->status == 'active' ? 'text-success' : 'text-danger' }}">
                                {{ $user->status }}
                            </span>
                        </div>
                    </div>
                    <div class="user-info-row">
                        <div class="user-info-label">Ngày tạo:</div>
                        <div class="user-info-value">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="btn-group-left mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-lg">Chỉnh sửa</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
