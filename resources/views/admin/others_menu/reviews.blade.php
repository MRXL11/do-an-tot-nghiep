@extends('admin.layouts.AdminLayouts')

@section('title')
  <title>Quản lý người dùng</title>
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    <div class="row g-4 mb-4">
        <div class="col-md-8">
          {{-- bắt đầu 1 danh mục      --}}
        <div class="card card-success collapsed-card">
            <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-box-seam me-2"></i>Áo Thun Nam
                <!-- Badge hiển thị số lượng đánh giá mới -->
                <span class="badge bg-danger ms-2 d-flex align-items-center">
                    <i class="bi bi-chat-left-text me-1"></i> 2 đánh giá mới
                </span>
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
            </div>
            </div>

            <!-- Thân đánh giá -->
            <div class="card-body">
            <!-- Ảnh sản phẩm + danh mục -->
            <div class="d-flex align-items-center mb-3">
                <img src="https://tse1.mm.bing.net/th?id=OIP.GYLRM2_f4FO2f02hDEo2CAHaJ4&pid=Api&P=0&h=180" alt="Ảnh sản phẩm" height="50px" class="rounded me-2 border">
                <div>
                <a href="/sanpham/ao-thun-nam" class="fw-semibold text-decoration-none">Áo thun thể thao nam</a><br>
                <span class="badge bg-primary"><i class="bi bi-tags me-1"></i>Quần áo</span>
                </div>
            </div>

            <!-- Đánh giá 1 -->
            <div class="mb-3 border-bottom pb-2">
                <div class="d-flex justify-content-between">
                <strong><i class="bi bi-person-circle me-1"></i>Trần Văn B</strong>
                <span class="text-warning">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                </span>
                </div>
                <small class="text-muted"><i class="bi bi-clock me-1"></i>20/05/2025</small>
                <p class="mt-2 mb-1">Sản phẩm mặc rất mát, chất lượng tuyệt vời!</p>

                <!-- Bình luận khách khác -->
                <div class="ms-3 mt-2 border-start ps-3">
                <div class="mb-2">
                    <strong><i class="bi bi-person-fill me-1"></i>Khách:</strong>
                    <span>Có co giãn không bạn?</span>
                </div>

                <!-- Trả lời của Admin -->
                <div class="mb-2">
                    <strong><i class="bi bi-person-badge me-1"></i>Admin:</strong>
                    <span>Dạ áo có co giãn nhẹ, phù hợp vận động ạ.</span>
                </div>

                <!-- Form trả lời -->
                <form class="mt-2">
                    <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Trả lời bình luận..." name="reply">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-send"></i>
                    </button>
                    </div>
                </form>
                </div>
            </div>
            <div class="mb-3 border-bottom pb-2">
                <div class="d-flex justify-content-between">
                <strong><i class="bi bi-person-circle me-1"></i>Nguyễn Văn A</strong>
                <span class="text-warning">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                </span>
                </div>
                <small class="text-muted"><i class="bi bi-clock me-1"></i>20/05/2025</small>
                <p class="mt-2 mb-1">Sản phẩm mặc rất mát, chất lượng tuyệt vời!</p>

                <!-- Bình luận khách khác -->
                <div class="ms-3 mt-2 border-start ps-3">
                <div class="mb-2">
                    <strong><i class="bi bi-person-fill me-1"></i>Khách:</strong>
                    <span>Có màu tím không shop?</span>
                </div>

                <!-- Trả lời của Admin -->
                <div class="mb-2">
                    <strong><i class="bi bi-person-badge me-1"></i>Admin:</strong>
                    <span>Dạ áo có co giãn nhẹ, phù hợp vận động ạ.</span>
                </div>

                <!-- Form trả lời -->
                <form class="mt-2">
                    <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Trả lời bình luận..." name="reply">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-send"></i>
                    </button>
                    </div>
                </form>
                </div>
            </div>
            <!-- Có thể thêm nhiều đánh giá khác ở đây -->

            </div>
        </div>
        <!-- Kết thúc 1 danh mục -->
        {{-- bắt đầu 1 danh mục      --}}
        <div class="card card-success collapsed-card">
            <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-box-seam me-1"></i>Áo Phông
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
            </div>
            </div>

            <!-- Thân đánh giá -->
            <div class="card-body">
            <!-- Ảnh sản phẩm + danh mục -->
            <div class="d-flex align-items-center mb-3">
                <img src="https://tse3.mm.bing.net/th?id=OIP.4xRZxR6wzpxbZMvI8a-fWgHaJ4&pid=Api&P=0&h=180" alt="Ảnh sản phẩm" height="50px" class="rounded me-2 border">
                <div>
                <a href="/sanpham/ao-thun-nam" class="fw-semibold text-decoration-none">Áo thun thể thao nam</a><br>
                <span class="badge bg-primary"><i class="bi bi-tags me-1"></i>Quần áo</span>
                </div>
            </div>

            <!-- Đánh giá 1 -->
            <div class="mb-3 border-bottom pb-2">
                <div class="d-flex justify-content-between">
                <strong><i class="bi bi-person-circle me-1"></i>Nguyễn Văn A</strong>
                <span class="text-warning">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                </span>
                </div>
                <small class="text-muted"><i class="bi bi-clock me-1"></i>20/05/2025</small>
                <p class="mt-2 mb-1">Sản phẩm mặc rất mát, chất lượng tuyệt vời!</p>

                <!-- Bình luận khách khác -->
                <div class="ms-3 mt-2 border-start ps-3">
                <div class="mb-2">
                    <strong><i class="bi bi-person-fill me-1"></i>Khách:</strong>
                    <span>Có co giãn không bạn?</span>
                </div>

                <!-- Trả lời của Admin -->
                <div class="mb-2">
                    <strong><i class="bi bi-person-badge me-1"></i>Admin:</strong>
                    <span>Dạ áo có co giãn nhẹ, phù hợp vận động ạ.</span>
                </div>

                <!-- Form trả lời -->
                <form class="mt-2">
                    <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Trả lời bình luận..." name="reply">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-send"></i>
                    </button>
                    </div>
                </form>
                </div>
            </div>
            <div class="mb-3 border-bottom pb-2">
                <div class="d-flex justify-content-between">
                <strong><i class="bi bi-person-circle me-1"></i>Nguyễn Văn A</strong>
                <span class="text-warning">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    <i class="bi bi-star"></i>
                </span>
                </div>
                <small class="text-muted"><i class="bi bi-clock me-1"></i>20/05/2025</small>
                <p class="mt-2 mb-1">Sản phẩm mặc rất mát, chất lượng tuyệt vời!</p>

                <!-- Bình luận khách khác -->
                <div class="ms-3 mt-2 border-start ps-3">
                <div class="mb-2">
                    <strong><i class="bi bi-person-fill me-1"></i>Khách:</strong>
                    <span>Có co giãn không bạn?</span>
                </div>

                <!-- Trả lời của Admin -->
                <div class="mb-2">
                    <strong><i class="bi bi-person-badge me-1"></i>Admin:</strong>
                    <span>Dạ áo có co giãn nhẹ, phù hợp vận động ạ.</span>
                </div>

                <!-- Form trả lời -->
                <form class="mt-2">
                    <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Trả lời bình luận..." name="reply">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-send"></i>
                    </button>
                    </div>
                </form>
                </div>
            </div>
            <!-- Có thể thêm nhiều đánh giá khác ở đây -->

            </div>
        </div>
        <!-- Kết thúc 1 danh mục -->
        </div>
        <div class="col-md-4">
           <!-- DIRECT CHAT -->
                <div class="card direct-chat direct-chat-primary mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Tin nhắn từ khách hàng</h3>
                    <div class="card-tools">
                      <span title="3 New Messages" class="badge text-bg-primary"> 3 </span>
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                      <button
                        type="button"
                        class="btn btn-tool"
                        title="Contacts"
                        data-lte-toggle="chat-pane"
                      >
                        <i class="bi bi-chat-text-fill"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                        <i class="bi bi-x-lg"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                      <!-- Message. Default to the start -->
                      <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-start"> Alexander Pierce </span>
                          <span class="direct-chat-timestamp float-end"> 23 Jan 2:00 pm </span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img
                          class="direct-chat-img"
                          src="../../dist/assets/img/user1-128x128.jpg"
                          alt="message user image"
                        />
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          Is this template really for free? That's unbelievable!
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->
                      <!-- Message to the end -->
                      <div class="direct-chat-msg end">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-end"> Sarah Bullock </span>
                          <span class="direct-chat-timestamp float-start"> 23 Jan 2:05 pm </span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img
                          class="direct-chat-img"
                          src="../../dist/assets/img/user3-128x128.jpg"
                          alt="message user image"
                        />
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">You better believe it!</div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->
                      <!-- Message. Default to the start -->
                      <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-start"> Alexander Pierce </span>
                          <span class="direct-chat-timestamp float-end"> 23 Jan 5:37 pm </span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img
                          class="direct-chat-img"
                          src="../../dist/assets/img/user1-128x128.jpg"
                          alt="message user image"
                        />
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          Working with AdminLTE on a great new app! Wanna join?
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->
                      <!-- Message to the end -->
                      <div class="direct-chat-msg end">
                        <div class="direct-chat-infos clearfix">
                          <span class="direct-chat-name float-end"> Sarah Bullock </span>
                          <span class="direct-chat-timestamp float-start"> 23 Jan 6:10 pm </span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img
                          class="direct-chat-img"
                          src="../../dist/assets/img/user3-128x128.jpg"
                          alt="message user image"
                        />
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">I would love to.</div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->
                    </div>
                    <!-- /.direct-chat-messages-->
                    <!-- Contacts are loaded here -->
                    <div class="direct-chat-contacts">
                      <ul class="contacts-list">
                        <li>
                          <a href="#">
                            <img
                              class="contacts-list-img"
                              src="../../dist/assets/img/user1-128x128.jpg"
                              alt="User Avatar"
                            />
                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Count Dracula
                                <small class="contacts-list-date float-end"> 2/28/2023 </small>
                              </span>
                              <span class="contacts-list-msg"> How have you been? I was... </span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img
                              class="contacts-list-img"
                              src="../../dist/assets/img/user7-128x128.jpg"
                              alt="User Avatar"
                            />
                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Sarah Doe
                                <small class="contacts-list-date float-end"> 2/23/2023 </small>
                              </span>
                              <span class="contacts-list-msg"> I will be waiting for... </span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img
                              class="contacts-list-img"
                              src="../../dist/assets/img/user3-128x128.jpg"
                              alt="User Avatar"
                            />
                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Nadia Jolie
                                <small class="contacts-list-date float-end"> 2/20/2023 </small>
                              </span>
                              <span class="contacts-list-msg"> I'll call you back at... </span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img
                              class="contacts-list-img"
                              src="../../dist/assets/img/user5-128x128.jpg"
                              alt="User Avatar"
                            />
                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Nora S. Vans
                                <small class="contacts-list-date float-end"> 2/10/2023 </small>
                              </span>
                              <span class="contacts-list-msg"> Where is your new... </span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img
                              class="contacts-list-img"
                              src="../../dist/assets/img/user6-128x128.jpg"
                              alt="User Avatar"
                            />
                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                John K.
                                <small class="contacts-list-date float-end"> 1/27/2023 </small>
                              </span>
                              <span class="contacts-list-msg"> Can I take a look at... </span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img
                              class="contacts-list-img"
                              src="../../dist/assets/img/user8-128x128.jpg"
                              alt="User Avatar"
                            />
                            <div class="contacts-list-info">
                              <span class="contacts-list-name">
                                Kenneth M.
                                <small class="contacts-list-date float-end"> 1/4/2023 </small>
                              </span>
                              <span class="contacts-list-msg"> Never mind I found... </span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                      </ul>
                      <!-- /.contacts-list -->
                    </div>
                    <!-- /.direct-chat-pane -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <form action="#" method="post">
                      <div class="input-group">
                        <input
                          type="text"
                          name="message"
                          placeholder="Type Message ..."
                          class="form-control"
                        />
                        <span class="input-group-append">
                          <button type="button" class="btn btn-primary">Send</button>
                        </span>
                      </div>
                    </form>
                  </div>
                  <!-- /.card-footer-->
                </div>
                <!-- /.direct-chat -->
        </div>
    </div>
    </div>
       
 </div>

@endsection