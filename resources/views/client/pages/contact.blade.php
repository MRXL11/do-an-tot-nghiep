@extends('client.pages.page-layout')
@section('content')
    @if (session('success'))
        <div class="alert alert-success mt-3 text-center">{{ session('success') }}</div>
    @endif

    <strong>
        <h2 class="text-center section-heading">Chào mừng bạn đến với website chúng tôi <br> Chúng tôi sử dụng mẫu độc quyền.
        </h2>
    </strong>
    <div class="container contact-us">
        <div class="row">
            <div class="col-lg-6">
                <div id="map" 
     style="cursor: pointer;"
     onclick="window.open('https://www.google.com/maps/place/Tr%C6%B0%E1%BB%9Dng+Cao+%C4%91%E1%BA%B3ng+FPT+Polytechnic/@21.0391705,105.7479312,16.11z/data=!4m6!3m5!1s0x313455e940879933:0xcf10b34e9f1a03df!8m2!3d21.0381298!4d105.7472618!16s%2Fg%2F11krd97y__?entry=ttu&g_ep=EgoyMDI1MDgyNS4wIKXMDSoASAFQAw%3D%3D', '_blank')">
    <iframe
        src="https://www.google.com/maps/embed?pb=..."
        width="100%" height="400px" frameborder="0" style="border:0; pointer-events: none;" allowfullscreen></iframe>
</div>
            </div>
            <div class="col-lg-6">
                <div class="section-heading">
                    <h3>Xin chào!</h3>
                    <span>Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi nào.</span>
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
                                <input name="email" type="text" id="email" placeholder="Địa chỉ email" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <textarea name="message" rows="6" id="message" placeholder="Nội dung tin nhắn" required></textarea>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <button type="submit" id="form-submit" class="main-dark-button"><i
                                        class="fa fa-paper-plane"></i> Gửi</button>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
@endsection
