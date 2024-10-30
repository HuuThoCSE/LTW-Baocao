<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận tài khoản</title>
</head>
<body>
    <h1>Xác nhận tài khoản</h1>
    <p>Vui lòng nhấp vào liên kết dưới đây để xác nhận tài khoản của bạn:</p>
    <a href="{{ route('confirm', ['email' => $email]) }}">Xác nhận tài khoản</a>
    <p>Sau khi xác nhận, bạn sẽ được yêu cầu đổi mật khẩu mới.</p>
</body>
</html>
