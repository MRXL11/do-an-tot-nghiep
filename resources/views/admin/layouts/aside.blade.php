 <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
     <!--begin::Sidebar Brand-->
     <div class="sidebar-brand">
         <!--begin::Brand Link-->
         <a href="" class="brand-link">
             <!--begin::Brand Image-->
             {{-- <img src="" alt="HN-447"
                 class="brand-image opacity-75 shadow" /> --}}
             <!--end::Brand Image-->
             <!--begin::Brand Text-->
             <span class="">ADMIN</span>
             <!--end::Brand Text-->
         </a>
         <!--end::Brand Link-->
     </div>
     <!--end::Sidebar Brand-->
     <!--begin::Sidebar Wrapper-->
     <div class="sidebar-wrapper">
         <nav class="mt-2">
             <!--begin::Sidebar Menu-->
             <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
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
                             <a href="{{ route('statistical') }}"
                                 class="nav-link {{ request()->routeIs('statistical') ? 'active' : '' }}">
                                    <i class="bi bi-bar-chart"></i>
                                 <p>Thống kê</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.users.index') }}"
                                 class="nav-link {{ request()->routeIs('users') ? 'active' : '' }}">
                                 <i class="bi bi-person"></i>
                                 <p>Người dùng</p>
                             </a>
                         </li>



                         <li class="nav-item">
                             <a href="{{ route('admin.products.index') }}"
                                 class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                 <i class="bi bi-box-seam"></i>
                                 <p>Sản Phẩm</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.orders.index') }}"
                                 class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}">
                                 <i class="bi bi-receipt"></i>
                                 <p>Đơn hàng</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('reviews') }}"
                                 class="nav-link {{ request()->routeIs('reviews') ? 'active' : '' }}">
                                 <i class="bi bi-star"></i>
                                 <p>Đánh giá</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.brands.index') }}"
                                 class="nav-link {{ request()->routeIs('brands') ? 'active' : '' }}">
                                 <i class="bi bi-tags"></i>
                                 <p>Thương hiệu</p>
                             </a>
                         </li>
                         <li class="nav-item">
                            <a href="{{ route('admin.coupons.index') }}"
                            class="nav-link {{ request()->routeIs('coupons') ? 'active' : '' }}">
                             <i class="bi bi-ticket-perforated"></i>
                             <p>Voucher</p>
                          </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('notifications') }}"
                                 class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}">
                                 <i class="bi bi-bell"></i>
                                 <p>Thông báo</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.categories.index') }}"
                                 class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                                 <i class="bi bi-folder"></i>
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
             <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                 <li class="nav-item menu-open">
                     <a href="#" class="nav-link active">
                         <i class="nav-icon bi bi-gear"></i>
                         <p>
                             Cài đặt
                             <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                     </a>
                     <ul class="nav nav-treeview">
                         <li class="nav-item">
                             <a href="" class="nav-link">
                                 <i class="bi bi-file-earmark-text"></i>
                                 <p>Bài viết</p>
                             </a>
                         </li>

                         <li class="nav-item">
                             <a href="" class="nav-link">
                                 <i class="bi bi-image"></i>
                                 <p>Banner</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="" class="nav-link">
                                 <i class="bi bi-person-circle"></i>
                                 <p>Profile</p>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('logout') }}" class="nav-link">
                                 <i class="bi bi-box-arrow-right"></i>
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
