@extends('main')

@section('title')
IT - Bảng điều khiển
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
