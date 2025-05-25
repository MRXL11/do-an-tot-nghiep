@extends('client.pages.page-layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
      <div class="card shadow-lg p-4 w-100" style="max-width: 500px;">
    <div class="text-center mb-4">
      <i class="bi bi-box-arrow-in-right text-success" style="font-size: 2rem;"></i>
      <h4 class="mt-2">Đăng nhập tài khoản</h4>
      <p class="text-muted">Chào mừng bạn quay trở lại!</p>
    </div>
    <form action="" method="POST">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Địa chỉ Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="********" required>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
      </div>
      <div class="d-grid">
        <button class="btn btn-outline-success" type="submit"><i class="bi bi-box-arrow-in-right me-1"></i> Đăng nhập</button>
      </div>
      <div class="text-center mt-3">
    <a href="" class="btn btn-outline-danger w-100">
        <i class="bi bi-google me-1"></i> Đăng nhập bằng Google
    </a>
    </div>

    </form>
    <div class="text-center mt-3">
      <small>Bạn chưa có tài khoản? <a href="">Đăng ký ngay</a></small>
    </div>
  </div>
</div>

@endsection
