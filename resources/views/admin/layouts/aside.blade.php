 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="" class="brand-link">
            <!--begin::Brand Image-->
            <img
           
               src="{{ asset('dist/assets/img/AdminLTELogo.png')}}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">ADMIN</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Quản lý
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                 <li class="nav-item">
                <a href="{{ route('statistical') }}" class="nav-link {{ request()->routeIs('statistical') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Thống kê</p>
              </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.users.*') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Người dùng</p>
                  </a>
                </li>

                  <li class="nav-item">
                    <a href="{{ route('products') }}" class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Sản Phẩm</p>
                    </a>
                </li>
                  <li class="nav-item">
                    <a href="{{ route('orders') }}" class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Đơn hàng</p>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('reviews') }}" class="nav-link {{ request()->routeIs('reviews') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Đánh giá</p>
                    </a>
                  </li>

                  <li class="nav-item">
                     <a href="{{ route('brands') }}" class="nav-link {{ request()->routeIs('brands') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Thương hiệu</p>
                    </a>
                  </li>
                  <li class="nav-item">
                   <a href="{{ route('vouchers') }}" class="nav-link {{ request()->routeIs('vouchers') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Voucher</p>
                    </a>
                  </li>
                  <li class="nav-item">
                     <a href="{{ route('notifications') }}" class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Thông báo</p>
                    </a>
                  </li>
                  <li class="nav-item">
                   <a href="{{ route('categories') }}" class="nav-link {{ request()->routeIs('categories') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Danh mục</p>
                    </a>
                  </li> 
                  
                </ul>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
           <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Cài đặt
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Bài viết</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Banner</p>
                    </a>
                  </li>
                    <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Profile</p>
                    </a>
                  </li>
                    <li class="nav-item">
                    <a href="" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Đăng xuất</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>