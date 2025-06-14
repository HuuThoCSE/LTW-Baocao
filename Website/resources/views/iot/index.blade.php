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
                                <!-- <div class="mt-3">
                                    <label for="lightBrightness" class="form-label">Độ sáng</label>
                                    <input type="range" class="form-range" id="lightBrightness" min="0" max="100">
                                    <span id="lightValue" class="ms-2">0%</span>
                                </div> -->
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
                                <!-- <div class="mt-3">
                                    <label for="fanSpeed" class="form-label">Tốc độ quạt</label>
                                    <select class="form-select" id="fanSpeed">
                                        <option value="1">Thấp</option>
                                        <option value="2">Trung bình</option>
                                        <option value="3">Cao</option>
                                    </select>
                                </div> -->
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
                                <!-- <div class="mt-3">
                                    <label for="mistInterval" class="form-label">Khoảng thời gian</label>
                                    <select class="form-select" id="mistInterval">
                                        <option value="5">5 phút/lần</option>
                                        <option value="10">10 phút/lần</option>
                                        <option value="15">15 phút/lần</option>
                                    </select>
                                </div> -->
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

                <!-- Thêm biểu đồ ánh sáng -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Biểu Đồ Ánh Sáng (24h Gần Nhất)</h5>
                            <div style="height: 300px;">
                                <canvas id="lightChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thêm biểu đồ NH3 -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Biểu Đồ NH3 (24h Gần Nhất)</h5>
                            <div style="height: 300px;">
                                <canvas id="nh3Chart"></canvas>
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
                            <span>Nhiệt độ: <strong id="currentTemp">--°C</strong></span>
                        </div>
                        <div class="sensor-item">
                            <i class="bi bi-droplet"></i>
                            <span>Độ ẩm: <strong id="currentHumidity">--%</strong></span>
                        </div>
                        <div class="sensor-item">
                            <i class="bi bi-brightness-high"></i>
                            <span>Ánh sáng: <strong id="currentLight">-- lux</strong></span>
                        </div>
                        <div class="sensor-item">
                            <i class="bi bi-cloud-haze2"></i>
                            <span>NH3: <strong id="currentNH3">-- ppm</strong></span>
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
    .toast-container {
        z-index: 1050;
    }
    .toast {
        opacity: 1 !important;
    }
    .toast-body {
        font-size: 0.95rem;
    }
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- MQTT.js -->
<script src="https://cdn.jsdelivr.net/npm/mqtt/dist/mqtt.min.js"></script>

<script>
    /* 
      ================================================
      ================  MQTT SECTION  ================
      ================================================
    */

    // Biến toàn cục cho MQTT client
    let client;

    // Hàm khởi tạo kết nối MQTT
    async function initializeMQTT() {
        try {
            if (typeof mqtt === 'undefined') {
                console.error('MQTT client not loaded');
                setTimeout(initializeMQTT, 1000);
                return;
            }

            // Thay bằng các thông số broker của bạn
            const mqttConfig = {
                host: 'k5debd44.ala.asia-southeast1.emqxsl.com', 
                port: 8084,
                path: '/mqtt',
                protocol: 'wss',
                username: 'fit21022008',
                password: 'fit21022008',
                clientId: 'webClient_' + Math.random().toString(16).substr(2, 8)
            };

            // Kết nối MQTT
            client = mqtt.connect(`${mqttConfig.protocol}://${mqttConfig.host}:${mqttConfig.port}${mqttConfig.path}`, {
                username: mqttConfig.username,
                password: mqttConfig.password,
                clientId: mqttConfig.clientId,
                clean: true,
                connectTimeout: 4000,
                reconnectPeriod: 1000,
                keepalive: 60
            });

            // Sự kiện khi kết nối thành công
            client.on('connect', function() {
                console.log('Connected to MQTT broker');
                subscribeToTopics();
            });

            // Sự kiện lỗi
            client.on('error', function(err) {
                console.error('MQTT Error:', err);
                showToast('Lỗi kết nối MQTT!', 'error');
            });

            // Sự kiện khi nhận message
            client.on('message', function(topic, message) {
                console.log('Received:', topic, message.toString());
                handleMQTTMessage(topic, message);
            });

        } catch (error) {
            console.error('Error in initializeMQTT:', error);
            showToast('Lỗi khởi tạo MQTT!', 'error');
        }
    }

    // Subscribe các topic cần thiết
    function subscribeToTopics() {
        if (client && client.connected) {
            // Ví dụ subscribe toàn bộ farm/# để bắt hết
            client.subscribe('farm/#', (err) => {
                if (!err) {
                    console.log('Subscribed to farm/#');
                } else {
                    console.error('Subscribe error:', err);
                }
            });
        } else {
            console.warn('Client not ready for subscribing');
        }
    }

    // Hàm handle message chung
    function handleMQTTMessage(topic, message) {
        const msgStr = message.toString();

        switch (topic) {
            // Nhận nhiệt độ
            case 'farm/temperature': {
                const temp = parseFloat(msgStr);
                if (!isNaN(temp)) {
                    // Cập nhật thẻ hiện tại
                    document.getElementById('currentTemp').textContent = temp + '°C';
                    // Cập nhật biểu đồ
                    updateCharts(temp, null, null);
                }
                break;
            }
            // Nhận độ ẩm
            case 'farm/humidity': {
                const hum = parseFloat(msgStr);
                if (!isNaN(hum)) {
                    // Cập nhật thẻ hiện tại
                    document.getElementById('currentHumidity').textContent = hum + '%';
                    // Cập nhật biểu đồ
                    updateCharts(null, hum, null);
                }
                break;
            }
            // Nhận ánh sáng
            case 'farm/light': {
                const light = parseFloat(msgStr);
                if (!isNaN(light)) {
                    document.getElementById('currentLight').textContent = light + ' lux';
                    // Cập nhật biểu đồ với giá trị ánh sáng
                    updateCharts(null, null, light);
                }
                break;
            }
            // Nếu cần handle thêm thì thêm vào
            default: {
                // Ví dụ: farm/devices/status/light, farm/devices/status/fan
                if (topic.startsWith('farm/devices/status/')) {
                    console.log('Cập nhật trạng thái thiết bị:', topic, msgStr);
                    // Ở đây ta có thể cập nhật UI theo trạng thái nếu muốn
                }
                break;
            }
            // Nhận NH3
            case 'farm/nh3': {
                const nh3 = parseFloat(msgStr);
                if (!isNaN(nh3)) {
                    document.getElementById('currentNH3').textContent = nh3 + ' ppm';
                    updateCharts(null, null, null, nh3);
                }
                break;
            }
        }
    }

    /* 
      ================================================
      ==========  DEVICE CONTROL SECTION  ============
      ================================================
    */

    // Publish điều khiển
    function pubControl(topic, payload) {
        if (!client || !client.connected) {
            showToast('Chưa kết nối MQTT!', 'error');
            return;
        }
        client.publish(topic, payload, { qos: 1 }, (err) => {
            if (err) {
                console.error('Publish error:', err);
                showToast('Lỗi gửi lệnh!', 'error');
            } else {
                console.log(`Sent: ${topic} - ${payload}`);
                showToast(`Đã gửi lệnh: ${payload}`, 'success');
            }
        });
    }

    // Gọi khi bật/tắt đèn
    function controlLight(isOn) {
        const topic = 'farm/control/light';
        pubControl(topic, isOn ? 'ON' : 'OFF');
    }

    // Gọi khi thay đổi độ sáng
    function controlBrightness(value) {
        const topic = 'farm/control/light/brightness';
        pubControl(topic, value.toString());
    }

    // Gọi khi bật/tắt quạt
    function controlFan(isOn) {
        const topic = 'farm/control/fan';
        pubControl(topic, isOn ? 'ON' : 'OFF');
    }

    // Gọi khi thay đổi tốc độ quạt
    function controlFanSpeed(speed) {
        const topic = 'farm/control/fan/speed';
        pubControl(topic, speed);
    }

    // Gọi khi bật/tắt phun sương
    function controlMist(isOn) {
        const topic = 'farm/control/mist';
        pubControl(topic, isOn ? 'ON' : 'OFF');
    }

    // Gọi khi thay đổi tần suất phun sương
    function controlMistInterval(interval) {
        const topic = 'farm/control/mist/interval';
        pubControl(topic, interval);
    }

    /* 
      ================================================
      ==============  CHART SECTION  ================
      ================================================
    */

    let temperatureChart = null;
    let humidityChart = null;
    let lightChart = null;
    let nh3Chart = null;

    function initCharts() {
        const tempCtx = document.getElementById('temperatureChart');
        const humCtx = document.getElementById('humidityChart');
        const lightCtx = document.getElementById('lightChart');
        const nh3Ctx = document.getElementById('nh3Chart');


        // Khởi tạo biểu đồ nhiệt độ
        temperatureChart = new Chart(tempCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Nhiệt độ (°C)',
                    data: [],
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 50
                    }
                }
            }
        });

        // Khởi tạo biểu đồ độ ẩm
        humidityChart = new Chart(humCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Độ ẩm (%)',
                    data: [],
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });

        // Thêm khởi tạo biểu đồ ánh sáng
        lightChart = new Chart(lightCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Ánh sáng (lux)',
                    data: [],
                    borderColor: 'rgb(255, 159, 64)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 1000
                    }
                }
            }
        });

        // Khởi tạo biểu đồ NH3
        nh3Chart = new Chart(nh3Ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'NH3 (ppm)',
                    data: [],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        suggestedMin: 0,
                        suggestedMax: 50
                    }
                }
            }
        });
    }

    // Thêm dữ liệu điểm mới vào chart
    function updateCharts(temp, hum, light, nh3) {
        const now = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });

        if (temp !== null && temperatureChart) {
            temperatureChart.data.labels.push(now);
            temperatureChart.data.datasets[0].data.push(temp);

            // Giới hạn tối đa 288 điểm (mỗi 5 phút 1 lần => 24h)
            if (temperatureChart.data.labels.length > 288) {
                temperatureChart.data.labels.shift();
                temperatureChart.data.datasets[0].data.shift();
            }
            temperatureChart.update('none');
        }

        if (hum !== null && humidityChart) {
            humidityChart.data.labels.push(now);
            humidityChart.data.datasets[0].data.push(hum);

            if (humidityChart.data.labels.length > 288) {
                humidityChart.data.labels.shift();
                humidityChart.data.datasets[0].data.shift();
            }
            humidityChart.update('none');
        }

        // Thêm xử lý ánh sáng
        if (light !== null && lightChart) {
            lightChart.data.labels.push(now);
            lightChart.data.datasets[0].data.push(light);

            if (lightChart.data.labels.length > 288) {
                lightChart.data.labels.shift();
                lightChart.data.datasets[0].data.shift();
            }
            lightChart.update('none');
        }

        // Thêm xử lý NH3
        if (nh3 !== null && nh3Chart) {
            nh3Chart.data.labels.push(now);
            nh3Chart.data.datasets[0].data.push(nh3);

            if (nh3Chart.data.labels.length > 288) {
                nh3Chart.data.labels.shift();
                nh3Chart.data.datasets[0].data.shift();
            }
            nh3Chart.update('none');
        }
    }

    // Lấy dữ liệu từ API (từ InfluxDB) và cập nhật cả biểu đồ lẫn card
    async function fetchSensorData() {
        try {
            // Lấy thời điểm hiện tại và 24h trước
            const endTime = new Date();
            const startTime = new Date(endTime.getTime() - (24 * 60 * 60 * 1000));
            
            const response = await fetch(`/api/sensor-data?start=${startTime.toISOString()}&end=${endTime.toISOString()}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const data = await response.json();
            
            // Log dữ liệu để debug
            console.log('Received sensor data:', data);

            // Kiểm tra dữ liệu có tồn tại và không phải null
            if (data.timestamps) {
                // Lọc bỏ các giá trị null
                const validData = data.timestamps.map((time, index) => ({
                    time,
                    temp: data.temperatures?.[index] || null,
                    hum: data.humidity?.[index] || null,
                    light: data.light?.[index] || null,
                    nh3: data.nh3?.[index] || null
                })).filter(item => item.temp !== null || item.hum !== null || item.light !== null || item.nh3 !== null);

                if (validData.length > 0) {
                    // Cập nhật biểu đồ nhiệt độ
                    if (temperatureChart) {
                        temperatureChart.data.labels = validData.map(d => d.time);
                        temperatureChart.data.datasets[0].data = validData.map(d => d.temp);
                        temperatureChart.update();
                    }

                    // Cập nhật biểu đồ độ ẩm
                    if (humidityChart) {
                        humidityChart.data.labels = validData.map(d => d.time);
                        humidityChart.data.datasets[0].data = validData.map(d => d.hum);
                        humidityChart.update();
                    }

                    // Cập nhật biểu đồ ánh sáng
                    if (lightChart) {
                        lightChart.data.labels = validData.map(d => d.time);
                        lightChart.data.datasets[0].data = validData.map(d => d.light);
                        lightChart.update();
                    }

                    // Cập nhật biểu đồ NH3
                    if (nh3Chart) {
                        nh3Chart.data.labels = validData.map(d => d.time);
                        nh3Chart.data.datasets[0].data = validData.map(d => d.nh3);
                        nh3Chart.update();
                    }

                    // Cập nhật giá trị hiện tại với giá trị cuối cùng có sẵn
                    const lastValidData = validData[validData.length - 1];
                    if (lastValidData.temp) {
                        document.getElementById('currentTemp').textContent = `${lastValidData.temp}°C`;
                    }
                    if (lastValidData.hum) {
                        document.getElementById('currentHumidity').textContent = `${lastValidData.hum}%`;
                    }
                    if (lastValidData.light) {
                        document.getElementById('currentLight').textContent = `${lastValidData.light} lux`;
                    }
                    if (lastValidData.nh3) {
                        document.getElementById('currentNH3').textContent = `${lastValidData.nh3} ppm`;
                    }
                }
            }
        } catch (error) {
            console.error('Error fetching sensor data:', error);
            showToast('Lỗi tải dữ liệu cảm biến!', 'error');
        }
    }

    /* 
      ================================================
      ==============  UI INTERACTION  ===============
      ================================================
    */

    // Toast
    function showToast(message, type = 'info') {
        // Xóa toast cũ nếu còn
        const oldToastContainer = document.querySelector('.toast-container');
        if (oldToastContainer) {
            oldToastContainer.remove();
        }

        // Tạo container cho toast nếu chưa có
        let toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(toastContainer);

        const toastHtml = `
            <div class="toast align-items-center text-white bg-${getBootstrapColor(type)} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="${getIcon(type)}"></i> ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        toastContainer.innerHTML = toastHtml;

        const toastEl = toastContainer.querySelector('.toast');
        const toast = new bootstrap.Toast(toastEl, {
            animation: true,
            autohide: true,
            delay: 3000
        });
        toast.show();
    }

    function getBootstrapColor(type) {
        switch(type) {
            case 'success': return 'success';
            case 'error':   return 'danger';
            case 'warning': return 'warning';
            default:        return 'info';
        }
    }
    function getIcon(type) {
        switch(type) {
            case 'success': return 'bi bi-check-circle-fill me-2';
            case 'error':   return 'bi bi-x-circle-fill me-2';
            case 'warning': return 'bi bi-exclamation-triangle-fill me-2';
            default:        return 'bi bi-info-circle-fill me-2';
        }
    }

    /* 
      ================================================
      =============  DOM EVENT BINDING  =============
      ================================================
    */

    document.addEventListener('DOMContentLoaded', function() {
        // 1. Khởi tạo chart
        initCharts();

        // 2. Lấy dữ liệu ban đầu từ API
        fetchSensorData();

        // 3. Khởi tạo kết nối MQTT
        initializeMQTT();

        // 4. Đặt lịch cập nhật dữ liệu từ API mỗi 5 phút (tùy chỉnh theo nhu cầu)
        setInterval(fetchSensorData, 5 * 60 * 1000);

        // 5. Gắn sự kiện điều khiển UI -> MQTT
        const lightSwitch = document.getElementById('lightSwitch');
        const lightBrightness = document.getElementById('lightBrightness');
        const fanSwitch = document.getElementById('fanSwitch');
        const fanSpeed = document.getElementById('fanSpeed');
        const mistSwitch = document.getElementById('mistSwitch');
        const mistInterval = document.getElementById('mistInterval');

        // Bật tắt đèn
        lightSwitch.addEventListener('change', function() {
            controlLight(this.checked);
        });

        // Điều chỉnh độ sáng
        lightBrightness.addEventListener('input', function() {
            document.getElementById('lightValue').textContent = this.value + '%';
            controlBrightness(this.value);
        });

        // Bật tắt quạt
        fanSwitch.addEventListener('change', function() {
            controlFan(this.checked);
        });

        // Thay đổi tốc độ quạt
        // fanSpeed.addEventListener('change', function() {
        //     controlFanSpeed(this.value);
        // });

        // Bật tắt phun sương
        mistSwitch.addEventListener('change', function() {
            controlMist(this.checked);
        });

        // Thay đổi tần suất phun sương
        // mistInterval.addEventListener('change', function() {
        //     controlMistInterval(this.value);
        // });
    });
</script>
@endpush
@endsection
