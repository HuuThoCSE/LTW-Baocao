@extends('main')

@section('title', 'BarnModel Details')

@section('content')
<!-- <div class="container mt-4">
    <h1 class="text-center mb-4">Barn Details</h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>{{ $barn->barn_name }}</h5>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $barn->barn_id }}</p>
            <p><strong>Location:</strong> {{ $barn->location ?? 'Not provided' }}</p>
            <p><strong>Description:</strong> {{ $barn->description ?? 'No description available' }}</p>
            <p><strong>Area ID:</strong> {{ $barn->area_id }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('barns.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div> -->


<div class="card">
    <div class="card-body">
    <h5 class="card-title"><h5>{{ $barn->barn_name }}</h5></h5>

    <!-- Default Tabs -->
    <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="myTabjustified" role="tablist">
        <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link w-100 active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-justified" type="button" role="tab" aria-controls="info" aria-selected="true">Info</button>
        </li>
        <li class="nav-item flex-fill" role="presentation">
        <button class="nav-link w-100" id="iot-tab" data-bs-toggle="tab" data-bs-target="#iot-justified" type="button" role="tab" aria-controls="iot" aria-selected="false">IoT</button>
        </li>
    </ul>
    <div class="tab-content pt-2" id="myTabjustifiedContent">

        <!-- Info Tab -->
        <div class="tab-pane fade show active" id="info-justified" role="tabpanel" aria-labelledby="info-tab">

            <div class="card">
                <div class="card-body mt-3">
                    <p><strong>ID:</strong> {{ $barn->barn_id }}</p>
                    <p><strong>Location:</strong> {{ $barn->location ?? 'Not provided' }}</p>
                    <p><strong>Description:</strong> {{ $barn->description ?? 'No description available' }}</p>
                    <p><strong>Area ID:</strong> {{ $barn->area_id }}</p>
                </div>
            </div>
        </div>

        <!-- IoT Tab -->
        <div class="tab-pane fade" id="iot-justified" role="tabpanel" aria-labelledby="iot-tab">
            <!-- Temperature Chart -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">{{ __('messages.temperature')}}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <canvas id="temperatureChart" style="height: 100px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>

                    <script>
                        let temperatureChart;
                        let humidityChart;

                        // Khởi tạo biểu đồ
                        function initCharts() {
                            if (!temperatureChart) {
                                const tempCtx = document.getElementById('temperatureChart').getContext('2d');
                                temperatureChart = new Chart(tempCtx, {
                                    type: 'line',
                                    data: {
                                        labels: @json($temperatureData['timestamps']),
                                        datasets: [{
                                            label: 'Nhiệt độ (°C)',
                                            data: @json($temperatureData['values']),
                                            borderColor: 'rgb(255, 99, 132)',
                                            tension: 0.1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: false
                                            }
                                        },
                                        animation: {
                                            duration: 0 // Tắt animation để cập nhật mượt hơn
                                        }
                                    }
                                });
                            }

                            if (!humidityChart) {
                                const humCtx = document.getElementById('humidityChart').getContext('2d');
                                humidityChart = new Chart(humCtx, {
                                    type: 'line',
                                    data: {
                                        labels: @json($humidityData['timestamps']),
                                        datasets: [{
                                            label: 'Độ ẩm (%)',
                                            data: @json($humidityData['values']),
                                            borderColor: 'rgb(54, 162, 235)',
                                            tension: 0.1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: false
                                            }
                                        },
                                        animation: {
                                            duration: 0 // Tắt animation để cập nhật mượt hơn
                                        }
                                    }
                                });
                            }
                        }

                        // Hàm cập nhật dữ liệu
                        function updateCharts() {
                            fetch(`/barns/{{ $barn->barn_id }}/data`)
                                .then(response => response.json())
                                .then(data => {
                                    if (temperatureChart && data.temperature) {
                                        temperatureChart.data.labels = data.temperature.timestamps;
                                        temperatureChart.data.datasets[0].data = data.temperature.values;
                                        temperatureChart.update('none'); // Sử dụng 'none' để tránh animation
                                    }

                                    if (humidityChart && data.humidity) {
                                        humidityChart.data.labels = data.humidity.timestamps;
                                        humidityChart.data.datasets[0].data = data.humidity.values;
                                        humidityChart.update('none'); // Sử dụng 'none' để tránh animation
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        }

                        // Khởi tạo khi trang load
                        document.addEventListener('DOMContentLoaded', function() {
                            initCharts();
                            
                            // Cập nhật dữ liệu mỗi 5 giây
                            const updateInterval = setInterval(updateCharts, 5000);

                            // Cleanup khi tab không còn active
                            document.addEventListener('visibilitychange', function() {
                                if (document.hidden) {
                                    clearInterval(updateInterval);
                                } else {
                                    updateCharts();
                                    setInterval(updateCharts, 5000);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div><!-- End Default Tabs -->

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close alerts after 10 seconds using vanilla JavaScript
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 10000);
    });
</script>

@endsection
