@extends('admin.layouts.AdminLayouts')

@section('title-page')
  <title>tên của trang cần truyền tới</title>
@endsection
@section('content')
<div class="container-fluid">
  <div class="col-lg-12">
    {{-- class này là độ dài tối đa --}}
    <div class="row g-4 mb-4">
      {{-- class này là làm bố cục lên cùng hàng --}}
    <div class="col-md-8">
        {{-- ở dây chứa nội dung bên trái --}}
        <h1>Mọi người sẽ crud ở đây</h1>
    </div>
   
      <div class="col-md-4">
        {{-- ở đây chứa nội dung bên phải       --}}
    </div>
  </div>
 </div>
</div>
@endsection