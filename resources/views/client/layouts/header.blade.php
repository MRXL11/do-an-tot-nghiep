<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" height="60">
                    </a>
                    <!-- ***** Logo End ***** -->

                    <!-- ***** Menu Start ***** -->
                    <ul class="nav align-items-center">
                        <li class="scroll-to-section">
                            <a href="{{ url('/') }}" class="{{ Request::is('index') ? 'active' : '' }}">Trang chủ</a>
                        </li>
                        <li class="scroll-to-section"><a href="#men">Nam</a></li>
                        <li class="scroll-to-section"><a href="#women">Nữ</a></li>
                        <li class="scroll-to-section"><a href="#kids">Trẻ em</a></li>
                        <li class="scroll-to-section">
                            <a href="{{ url('/products-client') }}" class="{{ Request::is('products-client') ? 'active' : '' }}">Sản phẩm</a>
                        </li>

                        <li class="submenu">
                            <a href="javascript:;">Trang</a>
                            <ul>
                                <li><a href="{{ url('/about') }}" class="{{ Request::is('about') ? 'active' : '' }}">Về chúng tôi</a></li>
                                <li><a href="{{ url('/contact') }}" class="{{ Request::is('contact') ? 'active' : '' }}">Liên hệ</a></li>
                                <li><a href="{{ url('/detail-product') }}" class="{{ Request::is('detail-product') ? 'active' : '' }}">Chi tiết sản phẩm</a></li>
                            </ul>
                        </li>

                        <!-- Tìm kiếm -->
                        <li>
                            <a href="#" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tìm kiếm">
                                <i class="bi bi-search fs-5 text-dark"></i>
                            </a>
                        </li>

                        <!-- Giỏ hàng -->
                        <li class="scroll-to-section position-relative">
                            <a href="{{ route('cart.index') }}" class="{{ Request::routeIs('cart.index') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Giỏ hàng">
                                <i class="bi bi-cart3 fs-5 text-dark position-relative">
                                    <span id="cart-count" 
                                        class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger {{ $cartCount == 0 ? 'd-none' : '' }}" 
                                        style="font-size: 0.65rem;">
                                        {{ $cartCount }}
                                    </span>
                                </i>
                            </a>
                        </li>

                        <!-- Yêu thích -->
                        <li class="scroll-to-section">
                            <a href="{{ url('/wishlist') }}" class="{{ Request::is('wishlist') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Yêu thích">
                                <i class="bi bi-heart fs-5"></i>
                            </a>
                        </li>

                        <!-- Tài khoản -->
                    <li class="submenu">
                        <a href="javascript:;">
                        <i class="bi bi-person-circle me-1"></i>
                        @auth
                            {{ Auth::user()->name }}
                        @else
                            Tài khoản
                        @endauth
                        </a>
                        <ul>
                            @auth
                                <li>
                                    <a href="{{ route('account.show') }}" class="{{ Request::route()->named('account.show') ? 'active' : '' }}">
                                        <i class="bi bi-person-lines-fill me-1"></i> Trang cá nhân
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/checkout') }}" class="{{ Request::is('checkout') ? 'active' : '' }}">
                                        <i class="bi bi-credit-card-fill me-1 text-success"></i> Thanh toán
                                    </a>
                                </li>
                                <li>
                                       <a href="{{ url('/client/notifications') }}" class="{{ Request::is('client.notifications') ? 'active' : '' }}">
                                            <i class="bi bi-bell-fill me-1 text-warning"></i> Thông báo  
                                            @isset($unreadCount)
                                                <span class="badge bg-danger unread-count">{{ $unreadCount }}</span>
                                            @endisset
                                        </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}">
                                        <i class="bi bi-box-arrow-right me-1 text-danger"></i> Đăng xuất
                                    </a>
                                </li>
                            @endauth

                            @guest
                                <li>
                                    <a href="{{ url('/register') }}" class="{{ Request::is('register') ? 'active' : '' }}">
                                        <i class="bi bi-person-plus-fill me-1 text-success"></i> Đăng ký
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/login') }}" class="{{ Request::is('login') ? 'active' : '' }}">
                                        <i class="bi bi-box-arrow-in-right me-1 text-primary"></i> Đăng nhập
                                    </a>
                                </li>
                            @endguest
                        </ul>
                    </li>
                    </ul>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
