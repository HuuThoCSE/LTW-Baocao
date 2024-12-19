# LTW-Baocao
### THÔNG TIN DỰ ÁN

Tuần 13 báo cáo (2-7/13/2024)

# INFO BASIC
- PHP version: 8.3.12

### HƯỚNG DẪN SỬ DỤNG LARAVEL
#### 1. Cấu hình Laravel

Laravel là một PHP Framework mã nguồn mở miễn phí, được phát triển bởi Taylor Otwell với phiên bản đầu tiên được ra mắt vào tháng 6 năm 2011. Laravel ra đời nhằm mục đích hỗ trợ phát triển các ứng dụng web, dựa trên mô hình MVC (Model – View – Controller).

**Link** https://github.com/laravel/laravel

##### 2. Cấu hình ban đầu
Chạy lệnh `php composer.phar install`

Copy file `.env.example` -> `.env` sau đó chạy lệnh `php artisan key:generate`

##### 3. Quy định về kiến trúc

###### a. Thư mục giao diện `resources/views/auth`

- Mỗi thư mục tương ứng với một tính năng trên giao diện

Ví dụ: `resources/views/auth/don-vi/don-vi.blade.php`

Trong đó `don-vi` là thư mục và `don-vi.blade.php` là giao diện sử dụng

###### b. Quy định đặt tên

- `resources/views/auth`: Đặt tên tiếng việt, không dấu mỗi từ cách nhau dấu gạch nối, ví dụ như `don-vi.blade.php`
- `app/Models/*`: Đặt tên theo database và in hoa chữ cái đầu mỗi từ và có hậu tố **Model**  `DonViModel.php`
- `app/Http/Controllers/*`: Đặt tên theo database và in hoa chữ cái đầu mỗi từ và có hậu tố **Controller** `DonViCOntroller.php`

## Laravel mySQL
```
# Nội dung file .env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=db_ventech
DB_USERNAME=root
DB_PASSWORD=    
```

## Laravel tạo Controller
```bash
php artisan make:controller DemoController
```

## Laravel Tạo Model
```bash
php artisan make:model DemoModel
```

## Cài bootrap
```
+ Sử dụng PHP version 8.1
+ Cú pháp: Đường dẫn đến thư mục public
    muốn sử dụng "bootstrap.min.css" nằm trong public ta phải thêm {{asset('')}} xong trỏ bắt đầu từ thư mục sau thư mục public là assets bỏ trong href
    ví du: <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
```

## Các extention cần bật
```
extension_dir = "ext"
extension=fileinfo
extension=gd
extension=mbstring
extension=openssl
extension=pdo_mysql
```

# Database
## Tạo migrate
```bash
php artisan make:migration create_farms_table
```

```bash
php artisan migrate:rollback
```

```bash
php artisan migrate:refresh
```

```bash
php artisan migrate:reset
```

## Tạo seeder
```bash
php artisan make:seeder GoatTableSeeder
```

## Tạo lại table và seeder
```bash
php artisan migrate:fresh --seed

```

## Khởi động toàn cục trong cùng một mạng nội bộ 
```
php artisan serve --host=0.0.0.0
```

# Khởi động cùng expose
```
php artisan serve --host=127.0.0.1 --port=8000
```

```
expose share http://127.0.0.1:8000

expose share http://127.0.0.1:8000 --subdomain=goatfarm
```

```
php artisan config:clear
```

# Quy chuẩn tên route và funtion controller | Chuẩn RESTful
- `.index`: Hiển thị danh sách.
- `.show`: Hiển thị chi tiết.
- `.create`: Hiển thị form tạo mới.
- `.store`: Lưu dữ liệu mới.
- `.edit`: Hiển thị form chỉnh sửa.
- `.update`: Cập nhật tài nguyên.
- `.destroy`: Xóa tài nguyên.


```
php artisan make:migration create_sensor_data_table --create=sensor_data
```

```
php artisan make:model SensorDataModel
```

```
php artisan make:controller API/SensorDataController
```

```
docker pull emqx/emqx:latest
```


```
docker run -d --name emqx -p 1883:1883 -p 18083:18083 emqx/emqx:latest
```

```
http://localhost:18083/
```

```
admin
public
```

# 1. Tạo Một Docker Network Riêng Biệt
```
docker network create emqx_influxdb_net
``

```
docker network create --driver bridge --attachable emqx_influxdb_net
```


docker stop emqx influxdb
docker rm emqx influxdb


docker network rm emqx_influxdb_net


docker network create --driver bridge emqx_influxdb_net



```
docker run -d `
    --name influxdb `
    --network emqx_influxdb_net `
    -p 8086:8086 `
    -v influxdb_data:/var/lib/influxdb2 `
    -e INFLUXDB_ADMIN_USER="admin" `
    -e INFLUXDB_ADMIN_PASSWORD="admin123" `
    -e INFLUXDB_ORG="emqx_org" `
    -e INFLUXDB_BUCKET="emqx_bucket" `
    -e INFLUXDB_TOKEN="emqx_token" `
    influxdb:2.7.11
```

```
docker run -d `
  --name emqx `
  --network emqx_influxdb_net `
  -p 1883:1883 `
  -p 8083:8083 `
  -p 18083:18083 `
  emqx/emqx:latest
```

vwULsSa2VowDA-KyyK2FhzeQKHY9uE2L5nEoW34y-DVIOvQz99tAeNdRpurqCbswFfE5oOdh0_4jn6jXB9xaZg==


```
http://influxdb:8086/api/v2/write?org=emqx_org&bucket=emqx_bucket&precision=ns
```


```
mosquitto_pub -h localhost -p 1883 -t "sensors/temperature" -m "25.3"
```

```
mosquitto_sub -h localhost -p 1883 -t "sensors/data" -v
``

mosquitto_sub -h localhost -p 1883 -t "#" -v

mosquitto_pub -h 172.18.0.3 -p 1883 -u "huuthocse" -P "123456" -t "sensors/data" -m "{\"temperature\": \"25.3\", \"humidity\": \"60\"}"

mosquitto_pub -h 172.18.0.3 -p 1883 -u "fit21022008" -P "fit21022008" -t "sensors/data" -m "{\"temperature\": \"25.3\", \"humidity\": \"60\"}"

mosquitto_pub -h localhost -p 1883 -u "fit21022008" -P "fit21022008" -t "sensors/data" -m "{\"temperature\": \"25.3\", \"humidity\": \"60\"}"

mosquitto_pub -h 172.18.0.3 -p 1883 -t "sensors/data" -m '{"temperature": 25.3, "humidity": 60}'

mosquitto_pub -h localhost -p 1883 -u "fit21022008" -P "fit21022008" -t "sensors/data" -m "{\"sensor_id\": \"1\", \"temperature\": \"25.3\", \"humidity\": \"60\"}"
