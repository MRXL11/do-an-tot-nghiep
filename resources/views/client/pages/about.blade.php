@extends('client.pages.page-layout')
@section('content')

<div class="container">
     @auth
    @if (is_null(Auth::user()->email_verified_at))
        <div class="alert alert-warning text-center mt-4">
            <strong>⚠ Email của bạn chưa được xác minh!</strong>

            @if(session('resent_code'))
                <div class="text-success mt-2">✅ Mã đã được gửi tới <b>{{ Auth::user()->email }}</b></div>
            @endif

            <form method="POST" action="{{ route('verify.send') }}" class="mt-2">
                @csrf
                <button class="btn btn-warning btn-sm">Gửi mã xác minh</button>
            </form>

            <form method="POST" action="{{ route('verify.check') }}" class="mt-2 w-50 mx-auto">
                @csrf
                <input type="text" name="code" class="form-control mb-2" placeholder="Nhập mã xác minh đã gửi đến email" required>
                <button class="btn btn-success btn-sm w-100">Xác minh</button>
            </form>
        </div>
    @else
        <div class="alert alert-success text-center mt-4">
            ✅ Email của bạn đã được xác minh!
        </div>
    @endif
    @endauth
<!-- ***** About Area Starts ***** -->
<div class="about-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="left-image">
                    <img src="assets/images/about-left-image.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="right-content">
                    <h4>Về Chúng Tôi &amp; Kỹ Năng Của Chúng Tôi</h4>
                    <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod kon tempor incididunt ut labore.</span>
                    <div class="quote">
                        <i class="fa fa-quote-left"></i><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiuski smod kon tempor incididunt ut labore.</p>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod kon tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-behance"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** About Area Ends ***** -->

<!-- ***** Our Team Area Starts ***** -->
<section class="our-team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Đội Ngũ Tuyệt Vời Của Chúng Tôi</h2>
                    <span>Chính những chi tiết nhỏ tạo nên sự khác biệt cho Hexashop so với các mẫu khác.</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="team-item">
                    <div class="thumb">
                        <div class="hover-effect">
                            <div class="inner-content">
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <img src="assets/images/team-member-01.jpg">
                    </div>
                    <div class="down-content">
                        <h4>Ragnar Lodbrok</h4>
                        <span>Chăm Sóc Sản Phẩm</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="team-item">
                    <div class="thumb">
                        <div class="hover-effect">
                            <div class="inner-content">
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <img src="assets/images/team-member-02.jpg">
                    </div>
                    <div class="down-content">
                        <h4>Ragnar Lodbrok</h4>
                        <span>Chăm Sóc Sản Phẩm</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="team-item">
                    <div class="thumb">
                        <div class="hover-effect">
                            <div class="inner-content">
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-behance"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <img src="assets/images/team-member-03.jpg">
                    </div>
                    <div class="down-content">
                        <h4>Ragnar Lodbrok</h4>
                        <span>Chăm Sóc Sản Phẩm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Our Team Area Ends ***** -->

<!-- ***** Services Area Starts ***** -->
<section class="our-services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Dịch Vụ Của Chúng Tôi</h2>
                    <span>Chính những chi tiết nhỏ tạo nên sự khác biệt cho Hexashop so với các mẫu khác.</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service-item">
                    <h4>Synther Vaporware</h4>
                    <p>Lorem ipsum dolor sit amet, consecteturti adipiscing elit, sed do eiusmod temp incididunt ut labore, et dolore quis ipsum suspend.</p>
                    <img src="assets/images/service-01.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service-item">
                    <h4>Locavore Squidward</h4>
                    <p>Lorem ipsum dolor sit amet, consecteturti adipiscing elit, sed do eiusmod temp incididunt ut labore, et dolore quis ipsum suspend.</p>
                    <img src="assets/images/service-02.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="service-item">
                    <h4>Health Gothfam</h4>
                    <p>Lorem ipsum dolor sit amet, consecteturti adipiscing elit, sed do eiusmod temp incididunt ut labore, et dolore quis ipsum suspend.</p>
                    <img src="assets/images/service-03.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Services Area Ends ***** -->

<!-- ***** Subscribe Area Starts ***** -->
<div class="subscribe">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-heading">
                    <h2>Bằng Cách Đăng Ký Nhận Bản Tin, Bạn Sẽ Nhận Được Giảm Giá 30%</h2>
                    <span>Chính những chi tiết nhỏ tạo nên sự khác biệt cho Hexashop so với các mẫu khác.</span>
                </div>
                <form id="subscribe" action="" method="get">
                    <div class="row">
                        <div class="col-lg-5">
                            <fieldset>
                                <input name="name" type="text" id="name" placeholder="Tên của bạn" required="">
                            </fieldset>
                        </div>
                        <div class="col-lg-5">
                            <fieldset>
                                <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Địa chỉ email của bạn" required="">
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
                            <li>Địa Chỉ Cửa Hàng:<br><span>Sunny Isles Beach, FL 33160, Hoa Kỳ</span></li>
                            <li>Điện Thoại:<br><span>010-020-0340</span></li>
                            <li>Vị Trí Văn Phòng:<br><span>North Miami Beach</span></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul>
                            <li>Giờ Làm Việc:<br><span>07:30 AM - 9:30 PM Hàng Ngày</span></li>
                            <li>Email:<br><span>info@company.com</span></li>
                            <li>Mạng Xã Hội:<br><span><a href="#">Facebook</a>, <a href="#">Instagram</a>, <a href="#">Behance</a>, <a href="#">Linkedin</a></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Subscribe Area Ends ***** -->
</div>

@endsection

