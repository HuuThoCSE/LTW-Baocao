@extends('main')

@section('title')
Điều khiển IoT - Trang trại dê thông minh
@endsection

@section('content')
<div class="pagetitle">
    <h1>Hệ Thống Điều Khiển IoT</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Điều khiển IoT</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <!-- Card điều khiển -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Điều Khiển Thiết Bị IoT</h5>
                    <div class="row">
                        <!-- Điều khiển đèn -->
                        <div class="col-md-4">
                            <div class="device-card">
                                <div class="device-icon">
                                    <i class="bi bi-lightbulb"></i>
                                </div>
                                <h4>Hệ thống đèn</h4>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="lightSwitch">
                                    <label class="form-check-label" for="lightSwitch">Bật/Tắt</label>
                                </div>
                                <div class="mt-3">
                                    <label for="lightBrightness" class="form-label">Độ sáng</label>
                                    <input type="range" class="form-range" id="lightBrightness" min="0" max="100">
                                </div>
                            </div>
                        </div>

                        <!-- Điều khiển quạt -->
                        <div class="col-md-4">
                            <div class="device-card">
                                <div class="device-icon">
                                    <i class="bi bi-fan"></i>
                                </div>
                                <h4>Quạt thông gió</h4>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="fanSwitch">
                                    <label class="form-check-label" for="fanSwitch">Bật/Tắt</label>
                                </div>
                                <div class="mt-3">
                                    <select class="form-select" id="fanSpeed">
                                        <option value="1">Tốc độ thấp</option>
                                        <option value="2">Tốc độ trung bình</option>
                                        <option value="3">Tốc độ cao</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Điều khiển phun sương -->
                        <div class="col-md-4">
                            <div class="device-card">
                                <div class="device-icon">
                                    <i class="bi bi-cloud-drizzle"></i>
                                </div>
                                <h4>Hệ thống phun sương</h4>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="mistSwitch">
                                    <label class="form-check-label" for="mistSwitch">Bật/Tắt</label>
                                </div>
                                <div class="mt-3">
                                    <select class="form-select" id="mistInterval">
                                        <option value="5">5 phút/lần</option>
                                        <option value="10">10 phút/lần</option>
                                        <option value="15">15 phút/lần</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ theo dõi -->
        <div class="col-lg-12">
            <div class="row">
                <!-- Biểu đồ nhiệt độ -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Biểu Đồ Nhiệt Độ (24h Gần Nhất)</h5>
                            <div style="height: 300px;">
                                <canvas id="temperatureChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ độ ẩm -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Biểu Đồ Độ Ẩm (24h Gần Nhất)</h5>
                            <div style="height: 300px;">
                                <canvas id="humidityChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông số hiện tại -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thông Số Hiện Tại</h5>
                    <div class="sensor-data">
                        <div class="sensor-item">
                            <i class="bi bi-thermometer-half"></i>
                            <span>Nhiệt độ: <strong id="currentTemp">27°C</strong></span>
                        </div>
                        <div class="sensor-item">
                            <i class="bi bi-droplet"></i>
                            <span>Độ ẩm: <strong id="currentHumidity">65%</strong></span>
                        </div>
                        <div class="sensor-item">
                            <i class="bi bi-brightness-high"></i>
                            <span>Ánh sáng: <strong id="currentLight">500 lux</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .device-card {
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }
    .device-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #4154f1;
    }
    .sensor-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .sensor-item i {
        margin-right: 10px;
        color: #4154f1;
    }
    .form-check-input {
        width: 60px;
        height: 30px;
    }
    .card {
        margin-bottom: 20px;
    }
    .card-title {
        padding-bottom: 15px;
        color: #012970;
        font-size: 18px;
        font-weight: 500;
    }
    /* Thêm style cho toast messages */
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }
    .toast-success {
        background-color: #28a745;
        color: white;
    }
    .toast-error {
        background-color: #dc3545;
        color: white;
    }
    .toast-warning {
        background-color: #ffc107;
        color: black;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/mqtt/dist/mqtt.min.js"></script>
<script>
    // Cấu hình MQTT
    const mqttConfig = {
        host: 'localhost',
        port: 8083,
        path: '/mqtt',
        protocol: 'ws',
        username: 'fit21022008',
        password: 'fit21022008',
        clientId: 'webClient_' + Math.random().toString(16).substr(2, 8)
    };

    // Khai báo client một lần duy nhất
    const client = mqtt.connect(`${mqttConfig.protocol}://${mqttConfig.host}:${mqttConfig.port}${mqttConfig.path}`, {
        username: mqttConfig.username,
        password: mqttConfig.password,
        clientId: mqttConfig.clientId,
        clean: true,
        connectTimeout: 4000,
        reconnectPeriod: 1000,
        keepalive: 60,
        rejectUnauthorized: false
    });

    // Xử lý các sự kiện kết nối
    client.on('connect', function() {
        console.log('Connected to MQTT broker');
        showToast('Kết nối MQTT thành công!', 'success');
        
        // Subscribe các topic
        client.subscribe('farm/temperature');
        client.subscribe('farm/humidity');
        client.subscribe('farm/devices/status/#');

        // Thêm dòng này: Gửi thông báo kết nối thành công vào broker
        client.publish('farm/connection', 'Web client connected successfully!', { retain: true });
    });

    client.on('error', function(error) {
        console.error('MQTT Error:', error);
        showToast('Lỗi kết nối MQTT!', 'error');
    });

    client.on('close', function() {
        console.log('MQTT connection closed');
        showToast('Mất kết nối MQTT!', 'warning');
    });

    client.on('reconnect', function() {
        console.log('Attempting to reconnect to MQTT broker...');
    });

    // Hàm hiển thị thông báo
    function showToast(message, type = 'info') {
        const toastDiv = document.createElement('div');
        toastDiv.className = `toast toast-${type} show`;
        toastDiv.textContent = message;
        document.body.appendChild(toastDiv);
        
        setTimeout(() => {
            toastDiv.remove();
        }, 3000);
    }

    // Các hàm điều khiển thiết bị
    function controlDevice(device, action) {
        if (client.connected) {
            const topic = `farm/control/${device}`;
            client.publish(topic, action, { qos: 1 }, function(err) {
                if (err) {
                    console.error('Publish error:', err);
                    showToast('Lỗi gửi lệnh!', 'error');
                } else {
                    console.log(`Sent: ${topic} - ${action}`);
                    showToast(`Đã gửi lệnh ${action} đến ${device}`, 'success');
                }
            });
        } else {
            showToast('Chưa kết nối MQTT!', 'error');
        }
    }

    // Đợi cho trang load xong
    window.addEventListener('load', function() {
        // Biểu đồ nhiệt độ
        new Chart(document.getElementById('temperatureChart'), {
            type: 'line',
            data: {
                labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
                datasets: [{
                    label: 'Nhiệt độ (°C)',
                    data: [25, 26, 27, 28, 30, 29, 27, 26],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Biểu đồ độ ẩm
        new Chart(document.getElementById('humidityChart'), {
            type: 'line',
            data: {
                labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
                datasets: [{
                    label: 'Độ ẩm (%)',
                    data: [65, 67, 70, 65, 60, 62, 65, 68],
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });

    // Khởi tạo biến cho biểu đồ
    let myChart;
    let temperatureData = [];
    let humidityData = [];
    let labels = [];

    // Xử lý nhận message
    client.on('message', function(topic, message) {
        console.log('Received:', topic, message.toString());
        
        switch(topic) {
            case 'farm/temperature':
                document.getElementById('currentTemp').textContent = message.toString() + '°C';
                updateTemperatureChart(message);
                break;
            case 'farm/humidity':
                document.getElementById('currentHumidity').textContent = message.toString() + '%';
                updateHumidityChart(message);
                break;
            case 'farm/light':
                document.getElementById('currentLight').textContent = message.toString() + ' lux';
                break;
            default:
                updateDeviceStatus(topic, message.toString());
        }
    });

    // Hàm điều khiển thiết bị
    function controlDevice(device, action) {
        const topic = `farm/control/${device}`;
        client.publish(topic, action);
        console.log(`Sent: ${topic} - ${action}`);
    }

    // Điều khiển độ sáng đèn
    function controlBrightness(value) {
        document.getElementById('lightValue').textContent = value + '%';
        client.publish('farm/control/light/brightness', value.toString());
    }

    // Điều khiển tốc độ quạt
    function controlFanSpeed(speed) {
        client.publish('farm/control/fan/speed', speed);
    }

    // Điều khiển thời gian phun sương
    function controlMistDuration(duration) {
        client.publish('farm/control/mist/duration', duration);
    }

    // Cập nhật trạng thái thiết bị
    function updateDeviceStatus(topic, message) {
        if (topic.startsWith('farm/devices/status/')) {
            const device = topic.split('/').pop();
            // Cập nhật UI dựa trên trạng thái nhận được
            console.log(`${device} status: ${message}`);
        }
    }

    // Khởi tạo biểu đồ
    window.addEventListener('load', function() {
        const ctx = document.getElementById('myChart');
        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Nhiệt độ (°C)',
                        data: temperatureData,
                        borderColor: 'rgb(255, 99, 132)',
                        tension: 0.1
                    },
                    {
                        label: 'Độ ẩm (%)',
                        data: humidityData,
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                },
                animation: {
                    duration: 0 // Tắt animation để cập nhật mượt hơn
                }
            }
        });
    });

    // Cập nhật biểu đồ
    function updateChart() {
        if (myChart) {
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = temperatureData;
            myChart.data.datasets[1].data = humidityData;
            myChart.update();
        }
    }

    // Thêm các event handlers sau phần khởi tạo MQTT
    document.getElementById('lightSwitch').addEventListener('change', function(e) {
        controlDevice('light', e.target.checked ? 'ON' : 'OFF');
    });

    document.getElementById('lightBrightness').addEventListener('input', function(e) {
        controlDevice('light/brightness', e.target.value);
    });

    document.getElementById('fanSwitch').addEventListener('change', function(e) {
        controlDevice('fan', e.target.checked ? 'ON' : 'OFF');
    });

    document.getElementById('fanSpeed').addEventListener('change', function(e) {
        controlDevice('fan/speed', e.target.value);
    });

    document.getElementById('mistSwitch').addEventListener('change', function(e) {
        controlDevice('mist', e.target.checked ? 'ON' : 'OFF');
    });

    document.getElementById('mistInterval').addEventListener('change', function(e) {
        controlDevice('mist/interval', e.target.value);
    });

    // Thêm hàm cập nhật biểu đồ với giới hạn dữ liệu
    function updateTemperatureChart(newValue) {
        const MAX_DATA_POINTS = 8; // Giới hạn số điểm dữ liệu
        
        temperatureData.push(parseFloat(newValue));
        if (temperatureData.length > MAX_DATA_POINTS) {
            temperatureData.shift();
        }
        
        labels.push(new Date().toLocaleTimeString());
        if (labels.length > MAX_DATA_POINTS) {
            labels.shift();
        }
        
        updateChart();
    }
</script>
@endpush
@endsection