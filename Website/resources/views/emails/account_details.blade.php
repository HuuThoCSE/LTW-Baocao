<!DOCTYPE html>
<html>
<head>
    <title>Thông Tin Tài Khoản</title>
</head>
<body>
<h1>Chào mừng đến với Hệ Thống Quản Lý Nông Trại!</h1>
<p>Xin chào {{ $userDetails['user_name'] }},</p>

<p>Tài khoản của bạn đã được tạo thành công. Dưới đây là thông tin đăng nhập của bạn:</p>

<ul>
    <li><strong>Email:</strong> {{ $userDetails['user_email'] }}</li>
    <li><strong>Mật khẩu:</strong> {{ $userDetails['user_password'] }}</li>
</ul>

<p>Vui lòng sử dụng thông tin trên để đăng nhập vào hệ thống. Hãy nhớ thay đổi mật khẩu sau lần đăng nhập đầu tiên để đảm bảo an toàn.</p>

<p>Trân trọng,</p>
<p>Đội ngũ Hệ Thống Quản Lý Nông Trại</p>
</body>
</html>
