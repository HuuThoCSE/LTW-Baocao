<?php
use \Illuminate\Support\Facades\Session;
?>

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
            <li class="breadcrumb-item active"><a href="{{ route('goats.index') }}">{{ __('messages.goat_list') }}</a></li>
        </ol>
    </nav>
</div>

<!-- GoatModel Information Card -->
<div class="card mb-4" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); overflow: hidden;">
    <div class="card-header text-center">
        <h3>Thông tin chi tiết của dê: {{ $goat->goat_name }} (ID: {{ $goat->goat_id }})</h3>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-between">
            <!-- Nút hiển thị ở trên bên trái (chỉ hiển thị nếu role = 3) -->
            @if((Session::get('user_role_id') == 4) || (Session::get('user_role_id') == 2))
                <div style="position: absolute; top: 80px; right: 10px;">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="addInfoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-plus"></i> Thêm thông tin
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="addInfoDropdown">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addWeightModal">
                                    <i class="fas fa-weight"></i> Thêm cân nặng
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addDiseaseModal">
                                    <i class="fas fa-notes-medical"></i> Thêm bệnh
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addFoodModal">
                                    <i class="fas fa-utensils"></i> Thêm đồ ăn
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Nội dung bên trái -->
            <div class="col-md-4">
                <div class="text-center">
                    <!-- Giữ nguyên khung ảnh -->
                    <div class="img-wrapper mt-4" style="position: relative; max-width: 80%; height: auto; overflow: hidden; border-radius: 10px; box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);">
                        <img src="{{ asset('assets/img/deboar.jpg') }}" alt="{{ $goat->goat_name }}" class="img-fluid"
                             style="width: 100%; height: auto; transition: transform 0.3s ease-in-out; border-radius: 10px;" />
                    </div>
                </div>
            </div>

            <!-- Nội dung bên phải -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mt-2">
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

<div class="modal fade" id="addWeightModal" tabindex="-1" aria-labelledby="addWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWeightModalLabel">Thêm cân nặng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addWeightForm" action="{{ route('goats.addWeight', ['id' => $goat->goat_id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="weightValue" class="form-label">Cân nặng (kg)</label>
                        <input type="number" class="form-control" id="weightValue" name="weight" placeholder="Nhập cân nặng" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú (tùy chọn)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addDiseaseModal" tabindex="-1" aria-labelledby="addDiseaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addDiseaseModalLabel">Thêm bệnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addDiseaseForm" action="{{ route('goats.addDisease', ['id' => $goat->goat_id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="diseaseName" class="form-label">Tên bệnh</label>
                        <input type="text" class="form-control" id="diseaseName" name="disease" placeholder="Nhập tên bệnh" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú (tùy chọn)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addFoodModal" tabindex="-1" aria-labelledby="addFoodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFoodModalLabel">Thêm đồ ăn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFoodForm" action="{{ route('goats.addFood', ['id' => $goat->goat_id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="foodName" class="form-label">Tên đồ ăn</label>
                        <input type="text" class="form-control" id="foodName" name="food" placeholder="Nhập tên đồ ăn" required>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú (tùy chọn)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Lưu</button>
                </form>
            </div>
        </div>
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
