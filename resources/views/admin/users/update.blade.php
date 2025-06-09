@extends('admin.layouts.AdminLayouts')

@section('title')
    <title>Chỉnh sửa người dùng</title>
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
        width: 65%;
        text-align: left;
    }

    .form-control-lg {
        font-size: 18px;
        padding: 10px;
    }

    .avatar-image {
        width: 128px;
        height: 128px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .btn-group-left {
        display: flex;
        justify-content: flex-start;
        gap: 12px;
    }
</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <h1 class="text-center mb-4">Chỉnh sửa người dùng</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="user-info-container">
                        {{-- Avatar --}}
                        <div class="user-info-row">
                            <div class="user-info-label">Avatar:</div>
                            <div class="user-info-value">
                                @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                    <img id="preview_avatar" src="{{ asset('storage/' . $user->avatar) }}" class="avatar-image">
                                @else
                                    <img id="preview_avatar" src="{{ asset('dist/assets/img/user1-128x128.jpg') }}" class="avatar-image">
                                @endif
                                <input type="file" name="avatar" accept="image/*" class="form-control form-control-lg mt-2">
                            </div>
                        </div>

                        {{-- Tên --}}
                        <div class="user-info-row">
                            <div class="user-info-label">Tên:</div>
                            <div class="user-info-value">
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control form-control-lg">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="user-info-row">
                            <div class="user-info-label">Email:</div>
                            <div class="user-info-value">
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control form-control-lg">
                            </div>
                        </div>

                        {{-- Số điện thoại --}}
                        <div class="user-info-row">
                            <div class="user-info-label">Số điện thoại:</div>
                            <div class="user-info-value">
                                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-control form-control-lg">
                            </div>
                        </div>

                        {{-- Địa chỉ --}}
                        <div class="user-info-row">
                            <div class="user-info-label">Địa chỉ:</div>
                            <div class="user-info-value">
                                <textarea name="address" rows="2" class="form-control form-control-lg">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>

                        {{-- Quyền --}}
                        <div class="user-info-row">
                            <div class="user-info-label">Quyền:</div>
                            <div class="user-info-value">
                                <select name="role_id" class="form-control form-control-lg">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Trạng thái --}}
                        <div class="user-info-row">
                            <div class="user-info-label">Trạng thái:</div>
                            <div class="user-info-value">
                                <select name="status" class="form-control form-control-lg">
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="btn-group-left mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">Quay lại</a>
                        <button type="submit" class="btn btn-success btn-lg">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- JS preview avatar --}}
<script>
    const avatarInput = document.querySelector('input[name="avatar"]');
    const previewAvatar = document.getElementById('preview_avatar');

    avatarInput.addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                previewAvatar.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            previewAvatar.src = "{{ asset('dist/assets/img/user1-128x128.jpg') }}";
        }
    });
</script>
@endsection

