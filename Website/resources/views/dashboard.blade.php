@extends('main')

@section('title')
Bảng điều khiển
@endsection

@section('dashboard_style')
<style>
   .container {
    display: flex; /* Sắp xếp các phần tử con nằm ngang */
    gap: 75px; /* Khoảng cách giữa các thẻ */
}

.image-card {
    background: rgba(172,200,238,0.4);
    backdrop-filter: blur(60px);
     /* fallback for old browsers */
    -webkit-backdrop-filter: blur(60px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 0 02px rgba(0, 0, 0, 0.2);
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    width: 250px;
    text-align: left;
    padding: 10px;
    transition: transform 0.3s ease; /* Thêm hiệu ứng mượt mà khi thay đổi kích thước */
    color: #333; /* Đổi màu chữ thành đen tối để dễ đọc hơn trên nền mờ */
}



.image-card .image-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
    z-index: 1; /* Đảm bảo ảnh không bị mờ */
}

.image-card img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    z-index: 1; /* Đảm bảo ảnh không bị mờ */
}

.image-card a {
    display: inline-block;
    padding: 10px;
    text-decoration: none;
    font-size: 18px;
    font-weight: bold;
    color: #007bff;
    transition: color 0.3s;
    z-index: 1; /* Đảm bảo chữ không bị mờ */
}

.image-card a:hover {
    color: #0056b3;
}

.image-card .description {
    background: rgba(166,248,236,0.35);
    backdrop-filter: blur(10px); /* Mờ nền cho phần mô tả */
    padding: 10px;
    border-radius: 5px;
    font-size: 16px;
    z-index: 1; /* Đảm bảo phần mô tả không bị mờ */
}

.image-card:hover {
    transform: scale(1.10); /* Tăng kích thước của thẻ lên 1.10 lần khi hover */
}

</style>
@endsection

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<div class="container">
    <!-- Thẻ 1 -->
    <div class="image-card">
        <div class="image-container">
            <img src="{{ asset('assets/img/food.png') }}" alt="Ảnh minh họa" style="width: 150px; height: auto;">
        </div>
        <hr>
        <div class="description">
        <a href="{{ route('food') }}" >Khám phá các loại thức ăn tốt nhất cho dê tại đây!</a>
        </div>
    </div>

    <!-- Thẻ 2 -->
    <div class="image-card">
        <div class="image-container">
            <img src="{{ asset('assets/img/goat.png') }}" alt="Ảnh minh họa" style="width: 150px; height: auto;">
        </div>
        <hr>
        <div class="description">
        <a href="{{ route('goats.list') }}">Khám phá các giống dê tốt nhất tại đây!</a>
        </div>
        
    </div>
    <div class="image-card">
        <div class="image-container">
            <img src="{{ asset('assets/img/farm5.png') }}" alt="Ảnh minh họa" style="width: 150px; height: auto;">
        </div>
        <hr>
        <div class="description">
        <a href="{{ route('listfarm') }}">Hệ thống trang trại tiên tiến nhất!</a>
        </div>
        
    </div>
    <div class="image-card">
        <div class="image-container">
            <img src="{{ asset('assets/img/medication.jpg') }}" alt="Ảnh minh họa" style="width: 150px; height: auto;">
        </div>
        <hr>
        <div class="description">
        <a href="{{ route('medication') }}">Các Thuốc Thiết Yếu Dành Cho Dê</a>
        </div>
        
    </div>
</div>

@endsection
