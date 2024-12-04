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
.dashboard-box {

    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
    background: rgba(172,200,238,0.4);
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(11px);
    -webkit-backdrop-filter: blur(11px);
    border: 1px solid rgba(120, 111, 111, 0.15);
}

h4 {
    font-family: sans-serif;
}
.text-center{
    font-family: sans-serif;
}
</style>
@endsection

@section('content')
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
        <a href="{{ route('food.list') }}" >Khám phá các loại thức ăn tốt nhất cho dê tại đây!</a>
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


<!-- Biểu đồ -->
<div class="mt-5 dashboard-box">
    <div class="mt-5">
        <h4 class="text-center">Thống Kê Số Lượng Dê Theo Chuồng</h4>
        <div class="text-center">January 1, 2024 - December 31, 2024</div>
        <canvas id="goatChart" style="max-height: 400px;"></canvas>
    </div>
</div>
@section('dashboard_script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('dashboard.data') }}') // Gọi route đã tạo
        .then(response => response.json())
        .then(data => {
            console.log(data); // Kiểm tra dữ liệu trả về

            if (data.length === 0) {
                console.error('Không có dữ liệu để hiển thị biểu đồ.');
                return; // Ngừng nếu không có dữ liệu
            }

            const labels = data.map(item => item.farm ? item.farm.farm_name : 'Chưa xác định');
            const quantities = data.map(item => Math.round(item.quantity)); // Làm tròn xuống số nguyên gần nhất

            // Tính giá trị lớn nhất trong số lượng dê để sử dụng trong trục Y
            const maxQuantity = Math.max(...quantities);

            const ctx = document.getElementById('goatChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số Lượng Dê',
                        data: quantities,
                        backgroundColor: '#3333CC', // Màu cột
                        borderColor: 'rgba(75, 192, 192, 1)', // Màu viền cột
                        borderWidth: 1,
                        barThickness: 40 // Điều chỉnh độ dày cột
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            min: 0,  // Giá trị bắt đầu của trục Y
                            max: maxQuantity + 2, // Giá trị kết thúc của trục Y (đặt lớn hơn max quantity)
                            stepSize: 5,  // Bước nhảy (ví dụ: mỗi lần nhảy 5)
                            title: {
                                display: true,
                                text: 'Số Lượng Dê'
                            },
                            ticks: {
                                precision: 0, // Đảm bảo không có phần thập phân
                                callback: function(value) {
                                    return value % 1 === 0 ? value : ''; // Hiển thị số nguyên
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tên Chuồng'
                            }

                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});



</script>
@endsection

@endsection
