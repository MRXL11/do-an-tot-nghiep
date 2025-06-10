@extends('client.pages.page-layout')


@section('content') 
<div class="container">
  <h4 class="mb-4"><i class="bi bi-bell-fill text-warning me-2"></i>Thông báo của bạn</h4>

  <!-- Bộ lọc + thao tác -->
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 bg-light p-3 rounded shadow-sm">
    <div class="d-flex flex-wrap gap-3">
      <div class="form-check">
        <input class="form-check-input filter-checkbox" type="checkbox" id="filter-all" checked>
        <label class="form-check-label" for="filter-all">Tất cả</label>
      </div>
      <div class="form-check">
        <input class="form-check-input filter-checkbox" type="checkbox" id="filter-read">
        <label class="form-check-label" for="filter-read">Đã đọc</label>
      </div>
      <div class="form-check">
        <input class="form-check-input filter-checkbox" type="checkbox" id="filter-unread">
        <label class="form-check-label" for="filter-unread">Chưa đọc <span class="badge bg-danger unread-count">2</span></label>
      </div>
    </div>

    <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0">
      <button class="btn btn-primary btn-sm" id="select-all"><i class="bi bi-check2-square me-1"></i> Chọn tất cả</button>
      <button class="btn btn-success btn-sm" id="mark-all-read"><i class="bi bi-eye me-1"></i> Đánh dấu đã đọc</button>
      {{-- <button class="btn btn-outline-danger btn-sm" id="delete-selected" disabled><i class="bi bi-trash me-1"></i> Xóa</button>
      <button class="btn btn-outline-dark btn-sm" id="delete-all"><i class="bi bi-x-circle me-1"></i> Xóa tất cả</button> --}}
    </div>
  </div>

  <!-- Danh sách thông báo -->
  <div class="accordion" id="notificationAccordion">
    @for ($i = 1; $i <= 3; $i++)
    <div class="accordion-item notification-card {{ $i == 1 ? 'notification-item-unread' : 'notification-item-read' }} bg-white shadow-sm border rounded" data-read="{{ $i == 1 ? 'false' : 'true' }}">
      <div class="d-flex align-items-center p-2  border">
        <!-- Checkbox căn giữa -->
        <div class="d-flex align-items-center justify-content-center me-3" style="min-width: 40px;">
          <input type="checkbox" class="form-check-input notification-checkbox">
        </div>

        <!-- Accordion nội dung -->
        <div class="flex-grow-1">
          <h2 class="accordion-header" id="heading{{ $i }}">
            <button class="accordion-button collapsed px-3 py-2 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#notif{{ $i }}">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp"
                   class="me-3 rounded" width="45" height="45" alt="Ảnh">
              <div>
                <span class="badge {{ $i == 1 ? 'bg-danger' : ($i == 2 ? 'bg-info' : 'bg-secondary') }} mb-1">
                  {{ $i == 1 ? 'Khuyến mãi' : ($i == 2 ? 'Sản phẩm mới' : 'Chính sách') }}
                </span>
                <div class="fw-semibold">
                  {{ $i == 1 ? 'Black Friday Giảm 30%' : ($i == 2 ? 'BST Mùa Đông 2025' : 'Cập nhật đổi trả') }}
                </div>
                <small class="text-muted">{{ now()->subDays($i)->format('d/m/Y, H:i') }}</small>
              </div>
            </button>
          </h2>
          <div id="notif{{ $i }}" class="accordion-collapse collapse" data-bs-parent="#notificationAccordion">
            <div class="accordion-body">
              @if ($i == 1)
                🎉 Giảm giá toàn bộ sản phẩm 30% từ 25–30/11! Mua ngay để không bỏ lỡ.
              @elseif ($i == 2)
                🔥 BST áo len, áo khoác thời trang giữ ấm cho mùa đông 2025.
              @else
                📋 Chính sách đổi hàng lên đến 30 ngày áp dụng toàn bộ đơn hàng.
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @endfor
  </div>

  <!-- Nút xem thêm -->
  <div class="text-center mt-4">
    <button class="btn btn-outline-warning load-more-btn text-dark">Xem thêm</button>
  </div>
</div>
@endsection


@section('scripts')
<script>
  const filters = document.querySelectorAll('.filter-checkbox');
  const notifications = document.querySelectorAll('.notification-card');
  const deleteSelectedBtn = document.getElementById('delete-selected');
  const deleteAllBtn = document.getElementById('delete-all');
  const selectAllBtn = document.getElementById('select-all');
  const markAllReadBtn = document.getElementById('mark-all-read');
  const notificationCheckboxes = document.querySelectorAll('.notification-checkbox');

  filters.forEach(filter => {
    filter.addEventListener('change', () => {
      filters.forEach(f => { if (f !== filter) f.checked = false; });
      const filterValue = filter.id;
      notifications.forEach(notification => {
        const isRead = notification.dataset.read === 'true';
        notification.style.display =
          (filterValue === 'filter-all') ||
          (filterValue === 'filter-read' && isRead) ||
          (filterValue === 'filter-unread' && !isRead) ? 'block' : 'none';
      });
    });
  });

  selectAllBtn.addEventListener('click', () => {
    const allChecked = Array.from(notificationCheckboxes).every(cb => cb.checked);
    notificationCheckboxes.forEach(cb => cb.checked = !allChecked);
    deleteSelectedBtn.disabled = !Array.from(notificationCheckboxes).some(cb => cb.checked);
  });

  notificationCheckboxes.forEach(cb => cb.addEventListener('change', () => {
    deleteSelectedBtn.disabled = !Array.from(notificationCheckboxes).some(cb => cb.checked);
  }));

  deleteSelectedBtn.addEventListener('click', () => {
    if (confirm('Bạn có chắc chắn muốn xóa các thông báo đã chọn?')) {
      notificationCheckboxes.forEach(cb => {
        if (cb.checked) cb.closest('.accordion-item').remove();
      });
      updateUnreadCount();
    }
  });

  deleteAllBtn.addEventListener('click', () => {
    if (confirm('Bạn có chắc chắn muốn xóa tất cả thông báo?')) {
      document.getElementById('notificationAccordion').innerHTML = `
        <div class="alert alert-info text-center">
          <i class="bi bi-inbox me-2"></i> Không có thông báo nào.
        </div>`;
      updateUnreadCount();
    }
  });

  markAllReadBtn.addEventListener('click', () => {
    notifications.forEach(notification => {
      notification.dataset.read = 'true';
      notification.classList.remove('notification-item-unread');
      notification.classList.add('notification-item-read');
    });
    updateUnreadCount();
  });

  function updateUnreadCount() {
    const unreadCount = document.querySelectorAll('.notification-card[data-read="false"]').length;
    document.querySelector('.unread-count').textContent = unreadCount;
    deleteSelectedBtn.disabled = true;
  }
</script>
@endsection