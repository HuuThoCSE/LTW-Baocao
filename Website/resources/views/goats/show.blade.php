@extends('main')

@section('title')
Bảng điều khiển
@endsection

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('goats.list') }}">{{ __('messages.goat_list') }}</a></li>
        </ol>
    </nav>
</div>

<!-- GoatModel Information Card -->
<div class="card mb-4" style="background: linear-gradient(135deg, #f3f4f6, #d1e7ff); border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); overflow: hidden;">
    <div class="card-header text-center" style="background: #4f6d7a; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;">
        <h3>Thông tin chi tiết của dê: {{ $goat->goat_name }} (ID: {{ $goat->goat_id }})</h3>
    </div>
    <div class="card-body" style="padding: 30px; background-color: rgba(255, 255, 255, 0.9); border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
        <div class="d-flex">
            <!-- Image on the left -->
            <div class="col-md-4">
                <div class="text-center">
                    <!-- Giữ nguyên khung ảnh -->
                    <div class="img-wrapper" style="position: relative; max-width: 80%; height: auto; overflow: hidden; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);">
                        <img src="{{ asset('assets/img/deboar.jpg') }}" alt="{{ $goat->goat_name }}" class="img-fluid"
                            style="width: 100%; height: auto; transition: transform 0.3s ease-in-out; border-radius: 10px;" />
                    </div>
                </div>
            </div>

            <!-- Information on the right -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Tên:</strong> {{ $goat->goat_name }}</p>
                        <p><strong>Tuổi:</strong> {{ $goat->goat_age }} tuổi</p>
                        <p><strong>Giống:</strong> {{ $goat->breed_name_vie }}</p>
                        <p><strong>Nguồn gốc:</strong> {{ $goat->origin }}</p>
                        <p><strong>Trang trại:</strong> {{ $goat->farm_name }}</p>
                        <p><strong>Khu vực:</strong> {{ $goat->location }}</p>
                        <p><strong>Cân nặng hiện tại:</strong>
                            @if($lastGoatWeight)
                                {{ $lastGoatWeight->weight }} kg ({{ $lastGoatWeight->created_at->format('H:i d-m-Y') }})
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- GoatModel Weight Chart Card -->
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
                            label: 'GoatModel Weight Over Time',
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
