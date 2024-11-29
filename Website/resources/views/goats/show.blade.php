@extends('main')

@section('title')
Bảng điều khiển
@endsection

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('home') }}">List of Goats</a></li>
        </ol>
    </nav>
</div>

<!-- Goat Information Card -->
<div class="card mb-4">
    <div class="card-header text-center">
        <h3>Thông tin chi tiết của dê: {{ $goat->goat_name }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Tên:</strong> {{ $goat->goat_name }}</p>
                <p><strong>Tuổi:</strong> {{ $goat->goat_age }} năm</p>
                <p><strong>Giống:</strong> {{ $goat->breed_name }}</p>
                <p><strong>Nguồn gốc:</strong> {{ $goat->origin }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Trang trại:</strong> {{ $goat->farm_name }}</p>
                <p><strong>Khu vực:</strong> {{ $goat->location }}</p>
                <p><strong>Cân nặng hiện tại:</strong> {{ $goat->weight }} kg</p>
            </div>
        </div>
        <!-- Goat Image (if available) -->
        <div class="text-center mt-3">
            <img src="{{ asset('resources/img/news-' . $goat->goat_id . '.jpg') }}" alt="{{ $goat->goat_name }}" class="img-fluid" 
            style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);" 
            onerror="this.onerror=null;this.src='{{ asset('img/default-goat.jpg') }}';" />
        </div>
    </div>
</div>

<!-- Goat Weight Chart Card -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title text-center">Goat Weight Over Time</h5>
        <!-- Line Chart -->
        <canvas id="lineChart" style="max-height: 400px;"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const labels = [
                    @foreach($goatWeights as $weight)
                        '{{ $weight->created_at }}',
                    @endforeach
                ];

                const data = [
                    @foreach($goatWeights as $weight)
                        {{ $weight->weight }},
                    @endforeach
                ];

                new Chart(document.querySelector('#lineChart'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Goat Weight Over Time',
                            data: data,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
        <!-- End Line Chart -->
    </div>
</div>

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
@endsection
