@extends('client.pages.page-layout')
@section('content')

@if(session('success'))
  <div class="alert alert-success mt-3 text-center">{{ session('success') }}</div>
@endif

<strong><h2 class="text-center section-heading">Chào mừng bạn đến với website chúng tôi <br> Chúng tôi sử dụng mẫu độc quyền.</h2></strong>
<div class="container contact-us">
  <div class="row">
    <div class="col-lg-6">
      <div id="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6674.6566184387675!2d105.74567779337463!3d21.03653833261307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455d366faa727%3A0x7bc55bfa99993fdd!2zMSBQLiBUcuG7i25oIFbEg24gQsO0LCBYdcOibiBQaMawxqFuZywgTmFtIFThu6sgTGnDqm0sIEjDoCBO4buZaSAxMDAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1754981907762!5m2!1svi!2s" width="100%" height="450px" frameborder="0" style="border:0" allowfullscreen></iframe>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="section-heading">
        <h3>Hãy Liên Hệ Với Chúng Tôi!</h3>
        <span>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn mọi lúc.</span>
      </div>
      <form id="contact" action="{{ route('contact.send') }}" method="post">
        @csrf
        <div class="row">
          <div class="col-lg-6">
            <fieldset>
              <input name="name" type="text" id="name" placeholder="Họ và tên" required>
            </fieldset>
          </div>
          <div class="col-lg-6">
            <fieldset>
              <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Email" required>
            </fieldset>
          </div>
          <div class="col-lg-12">
            <fieldset>
              <textarea name="message" rows="6" id="message" placeholder="Nội dung" required></textarea>
            </fieldset>
          </div>
          <div class="col-lg-12">
            <fieldset>
              <button type="submit" id="form-submit" class="main-dark-button"><i class="fa fa-paper-plane"></i> Gửi</button>
            </fieldset>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="subscribe mt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="section-heading">
          <h2>Đăng Ký Nhận Bản Tin Để Nhận Ưu Đãi Đặc Biệt</h2>
          <span>Đăng ký ngay để nhận thông tin mới nhất về sản phẩm, khuyến mãi và xu hướng thời trang.</span>
        </div>
        <form id="subscribe" action="{{ route('newsletter.subscribe') }}" method="get">
          <div class="row">
            <div class="col-lg-5">
              <fieldset>
                <input name="name" type="text" id="name" placeholder="Họ và tên" required>
              </fieldset>
            </div>
            <div class="col-lg-5">
              <fieldset>
                <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Email" required>
              </fieldset>
            </div>
            <div class="col-lg-2">
              <fieldset>
                <button type="submit" id="form-submit" class="main-dark-button"><i class="fa fa-paper-plane"></i></button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-4">
        <div class="row">
          <div class="col-6">
            <ul>
              <li>Địa Chỉ Cửa Hàng:<br><span>Số 1 Trịnh Văn Bô, Hà Nội</span></li>
              <li>Điện Thoại:<br><span>010-020-0340</span></li>
              <li>Văn Phòng:<br><span>Fpt</span></li>
            </ul>
          </div>
          <div class="col-6">
            <ul>
              <li>Giờ Làm Việc:<br><span>07:30 Sáng - 9:30 Tối hàng ngày</span></li>
              <li>Email:<br><span>HN_447@company.com</span></li>
              <li>Mạng Xã Hội:<br><span><a href="#">Facebook</a>, <a href="#">Instagram</a>, <a href="#">Behance</a>, <a href="#">LinkedIn</a></span></li>, 

            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
