@extends('client.pages.page-layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
<div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
    <div class="text-center">
      <i class="bi bi-person-plus-fill text-primary" style="font-size: 2rem;"></i>
      <h4 class="mt-2">Tạo tài khoản mới</h4>
      <p class="text-muted">Vui lòng điền thông tin bên dưới để đăng ký</p>
    </div>
    <form action="" method="POST">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Họ tên</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Nguyễn Văn A" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Địa chỉ Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="********" required>
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="********" required>
      </div>
      <div class="d-grid">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-person-check me-1"></i> Đăng ký</button>
      </div>
      <div class="text-center mt-3">
  <a href="" class="btn btn-outline-danger w-100">
    <i class="bi bi-google me-1"></i> Đăng nhập bằng Google
  </a>
</div>

    </form>
    <div class="text-center mt-3">
      <small>Bạn đã có tài khoản? <a href="">Đăng nhập</a></small>
    </div>
  </div>
</div>
@endsection
