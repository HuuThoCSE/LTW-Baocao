@extends('auth/main')

@section('title')
Đăng nhập
@endsection

@section('link')
<style>
    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}

#login {
    margin: 0;
    width: 100%; /* Đảm bảo chiều rộng 100% */
    height: 100vh; /* Chiều cao 100% của viewport */
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url("{{ asset('assets/img/Login1.jpg') }}"); /* Thêm hình ảnh nền */
    background-size: cover; /* Đảm bảo hình ảnh lấp đầy phần tử */
    background-attachment: fixed;
    background-position: center; /* Căn giữa hình ảnh */
    background-repeat: no-repeat; /* Không lặp lại hình ảnh */
}
#login::before {
    content: ""; /* Tạo một pseudo-element */
    position: absolute; /* Đặt nó ở vị trí tuyệt đối */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("{{ asset('assets/img/Login1.jpg') }}"); /* Hình nền */
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    filter: blur(8px); /* Độ mờ */
    z-index: 1; /* Đặt lớp này phía dưới các nội dung khác */
}
#form-login{
    max-width: 400px;
    background: white; /* Màu nền với độ trong suốt */
    flex-grow: 1;
    padding: 30px 30px 40px;
    border-radius: 8px; /* Bo tròn khung */
    box-shadow: 0px 0px 15px 5px rgba(255, 255, 255, 0.8); /* Thêm độ bóng */
    position: relative; /* Để đảm bảo form nằm trên lớp mờ */
    z-index: 2; /* Đặt z-index cao hơn để nằm trên lớp mờ */
}
.form-heading{
    font-family: sans-serif;
    font-size: 35px;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
}
.form-group{
    border-bottom: 1px solid black;
    margin-top: 15px;
    margin-bottom: 25px;
    display: flex;
}
.form-input{
    background: transparent;
    border: 2px solid #f5f5f5; /* Đặt viền với chiều rộng là 2px */
    border-radius: 4px; /* Bo tròn viền */
    outline: 0;
    color: black;
    padding: 10px; /* Khoảng cách bên trong trường nhập liệu */
    width: 100%; /* Đặt chiều rộng là 100% của khung chứa */
    box-sizing: border-box; /* Đảm bảo padding và border nằm trong kích thước tổng thể */
}
.form-input::placeholder{
    color: #f5baba; /* Màu chữ của placeholder */
    opacity: 0.7; /* Độ mờ của chữ placeholder */
}
.form-submit{
    font-family: sans-serif;
    background-color: #2980b9;
    border: 1px solid;
    color: white;
    width: 100%;
    text-align: center;
    font-size: 20px;
    border-radius: 4px;
    transition: opacity 0.3s;
}
.form-submit:hover {
    background-color: #2980b9; /* Màu nền khi hover */
    opacity: 0.7; /* Làm mờ nút khi hover */
}
</style>
@endsection

@section('contents')

<div id="login">
    <form action="{{ route('login') }}" id="form-login" method="POST">
        @csrf
        <h1 class="form-heading">Đăng Nhập</h1>
        <div class="form-group">
            <input type="email" class="form-input" placeholder="Email đăng nhập" id="username" name="email" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-input" placeholder="Mật khẩu" id="password" name="password" required>
        </div>
        <input type="submit" value="Đăng Nhập" class="form-submit">
        @if ($errors->any())
            <div style="color: red; text-align: center; margin-top: 15px;">
                {{ $errors->first('email') }}
            </div>
        @endif
    </form>
</div>
@endsection

