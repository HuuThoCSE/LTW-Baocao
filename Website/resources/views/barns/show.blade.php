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
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('messages.temperature')}}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <canvas id="temperatureChart" style="height: 100px; width: 100%;"></canvas>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var ctx = document.getElementById('temperatureChart').getContext('2d');
                            var temperatureChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00'],
                                    datasets: [{
                                        label: 'Temperature (°C)',
                                        data: [25, 26, 25, 24, 23, 24, 25, 27, 28, 29, 30, 31],
                                        borderColor: 'rgb(255, 99, 132)',
                                        tension: 0.1,
                                        fill: false
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Temperature Over Time'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: false,
                                            title: {
                                                display: true,
                                                text: 'Temperature (°C)'
                                            }
                                        },
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Time'
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">{{ __('messages.humidity')}}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <canvas id="humidityChart" style="height: 100px; width: 100%;"></canvas>
                    </div>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var ctx = document.getElementById('humidityChart').getContext('2d');
                            var humidityChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00'],
                                    datasets: [{
                                        label: '{{ __('messages.humidity')}} (%)',
                                        data: [65, 63, 68, 70, 72, 75, 73, 70, 68, 65, 63, 60],
                                        borderColor: 'rgb(54, 162, 235)',
                                        tension: 0.1,
                                        fill: false
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Humidity Over Time'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: false,
                                            title: {
                                                display: true,
                                                text: '{{ __('messages.humidity')}} (%)'
                                            }
                                        },
                                        x: {
                                            title: {
                                                display: true,
                                                text: '{{ __('messages.time')}}'
                                            }
                                        }
                                    }
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
@endsection
