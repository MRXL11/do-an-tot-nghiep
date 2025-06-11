@extends('admin.layouts.AdminLayouts')
@section('title-page')
    <title>Chỉnh sửa danh mục</title>
@endsection
@section('content')
    <div class="container">
       
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tên danh mục</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Kích hoạt</option>
                    <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                </select>
                @error('status')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection