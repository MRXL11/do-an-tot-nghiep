<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" height="60">
                    </a>
                    <ul class="nav align-items-center">
                        {{-- SỬA LẠI CÁC LIÊN KẾT GÂY LỖI JAVASCRIPT --}}
                        <li> <a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Trang chủ</a>
                        </li>
                        <li class="scroll-to-section"><a href="{{ url('/#men') }}">Nam</a></li>
                        <li class="scroll-to-section"><a href="{{ url('/#women') }}">Nữ</a></li>
                        <li class="scroll-to-section"><a href="{{ url('/#kids') }}">Trẻ em</a></li>
                        <li> <a href="{{ url('/products-client') }}"
                                class="{{ Request::is('products-client*') ? 'active' : '' }}">Sản phẩm</a>
                        </li>

                        <li class="submenu">
                            <a href="javascript:;">Trang</a>
                            <ul>
                                <li><a href="{{ url('/about') }}" class="{{ Request::is('about') ? 'active' : '' }}">Về chúng tôi</a></li>
                                <li><a href="{{ url('/fashion-newsletters') }}"
                                            class="{{ Request::is('fashion-newsletters') ? 'active' : '' }}">Tin thời trang</a></li>        
                                <li><a href="{{ url('/contact') }}"
                                        class="{{ Request::is('contact') ? 'active' : '' }}">Liên hệ</a></li>
                            </ul>
                        </li>

                        <li class="nav-item position-relative">
                            <a href="#" id="searchToggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tìm kiếm">
                                <i class="bi bi-search fs-5 text-dark"></i>
                            </a>
                            <form action="{{ route('products-client') }}" method="GET" class="position-absolute top-100 start-0 mt-2 d-none" id="headerSearchForm" style="min-width: 250px; z-index: 1000;">
                                <input type="text" name="header_search" class="form-control form-control-sm" placeholder="Tìm kiếm..."  value="{{ request()->is('products-client*') ? request('header_search') : '' }}">
                            </form>
                        </li>

                        <li class="nav-item position-relative">
                            <a href="{{ route('cart.index') }}"
                                class="{{ Request::routeIs('cart.index') ? 'active' : '' }}" data-bs-toggle="tooltip"
                                title="Giỏ hàng">
                                <i class="bi bi-cart3 fs-5 text-dark position-relative">
                                    <span id="cart-count"
                                        class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger {{ ($cartCount ?? 0) == 0 ? 'd-none' : '' }}"
                                        style="font-size: 0.65rem;">
                                        {{ $cartCount ?? 0 }}
                                    </span>
                                </i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/wishlist') }}" class="{{ Request::is('wishlist') ? 'active' : '' }}"
                                data-bs-toggle="tooltip" title="Yêu thích">
                                <i class="bi bi-heart fs-5"></i>
                            </a>
                        </li>

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
                                        <a href="{{ route('account.show') }}"
                                            class="{{ Request::route()->named('account.show') ? 'active' : '' }}">
                                            <i class="bi bi-person-lines-fill me-1"></i> Trang cá nhân
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('orders.index') }}"
                                            class="{{ Request::route()->named('orders.index') ? 'active' : '' }}">
                                            <i class="bi bi-journal-text me-1"></i> Đơn hàng
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/client/notifications') }}"
                                            class="{{ Request::is('client.notifications') ? 'active' : '' }}">
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
                                        <a href="{{ url('/register') }}"
                                            class="{{ Request::is('register') ? 'active' : '' }}">
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
                    </nav>
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('searchToggle');
        const form = document.getElementById('headerSearchForm');
        if (!toggle || !form) return;

        const input = form.querySelector('input[name=\"header_search\"]');
        
        if (window.location.pathname.includes('products-client') && input.value) {
            form.classList.remove('d-none');
        } else {
            form.classList.add('d-none');
        }
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            form.classList.toggle('d-none');
            if (!form.classList.contains('d-none')) {
                input.focus();
            }
        });
        
        document.addEventListener('click', function(e) {
            if (!form.contains(e.target) && !toggle.contains(e.target)) {
                form.classList.add('d-none');
            }
        });
    });
</script>