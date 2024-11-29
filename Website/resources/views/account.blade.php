@extends('main')

@section('title')
Quản lý tài khoản
@endsection
@section('account_style')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 18px;
        text-align: left;
    }

    table, th, td {
        border: 1px solid #dddddd;
    }

    th, td {
        padding: 12px;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr {
    cursor: pointer; /* Thay đổi con trỏ để chỉ ra rằng hàng có thể click */
}

    tr:hover {
        background-color: #f1f1f1;
    }

    .pagetitle {
        margin-bottom: 20px;
    }

    .breadcrumb a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }
</style>
@endsection
@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Account</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
    
<div class="card">
    <div class="card-header">
        <h1>Danh sách tài khoản</h1>
    </div>

    <div class="card-body">
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Ngày Tạo</th>
                <th colspan="2">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->user_email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td align='center'>
                <form action="{{ route('account.del', $user->user_id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</button>
                </form>
            </td>
            <td>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#udpModal">Update</button>
            </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
<button id="newaccBtn" class="btn btn-primary" onclick="showAddAccForm()">Đăng ký tài khoản tại đây</button>

<!-- Ẩn form đăng ký mặc định -->
<div id="addaccForm" style="display: none;">
    <!-- Hiển thị lỗi farm_id nếu có -->
@if ($errors->has('farm_id'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ $errors->first('farm_id') }}</li>
        </ul>
    </div>
@endif

<!-- Hiển thị lỗi email nếu có -->
@if ($errors->has('email'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ $errors->first('email') }}</li>
        </ul>
    </div>
@endif

<!-- Form đăng ký -->
<form action="{{ route('user.add') }}" method="POST">
    @csrf
    <h2>Đăng ký tài khoản</h2>
    <label for="">Tên tài khoản</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}"><br>
    <label for="">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required><br>
    <label for="">Mật khẩu</label>
    <input type="password" name="mk" class="form-control"><br>
    <label for="farm_id">Farm ID:</label>
    <input type="number" name="farm_id" class="form-control" value="{{ old('farm_id') }}" required>
    <label for="farm_id">ID quyền:</label>
    <input type="number" name="role_id" class="form-control" value="{{ old('id') }}" required>
    <input type="submit" value="Thêm tài khoản" class="btn btn-primary">
</form>

</div>

<script>
        function showAddAccForm() {
            // Ẩn nút New Goat và hiện form Add Goat
            document.getElementById('newaccBtn').style.display = 'none';
            document.getElementById('addaccForm').style.display = 'block';
        }
    </script>
@foreach($users as $user)
            <div class="modal fade" id="udpModal{{$user->user_id}}" tabindex="-1">
                <div class="modal-dialog modal-small">
                <div class="modal-content">
                <form id="updateForm{{$user->user_id}}" method="POST" action="{{ route('account.udp', ['id' => $user->user_id] )}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật tài khoản</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Tên:</label>
                            <input type="text" name="name" value="{{ $user->user_name }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" value="{{ $user->user_email }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Mật khẩu:</label>
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới (để trống nếu không thay đổi)">
                        </div>
                        <div class="form-group">
                            <label for="farm_id" class="form-label">Farm ID:</label>
                            <input type="text" name="farm_id" value="{{ $user->farm_id }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="farm_id" class="form-label">ID quyền:</label>
                            <input type="text" name="role_id" value="{{ $user->farm_id }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <input class="btn btn-primary" type="submit" value="Lưu thay đổi">
                    </div>
                </form>

                
                </div>
            </div>
            @endforeach

            <tbody>
    @foreach ($users as $user)
        <tr style="cursor: pointer;">
            <td><a href="{{ route('account.show', ['id' => $user->user_id]) }}" style="text-decoration: none; color: inherit;">{{ $user->user_id }}</a></td>
            <td><a href="{{ route('account.show', ['id' => $user->user_id]) }}" style="text-decoration: none; color: inherit;">{{ $user->user_name }}</a></td>
            <td><a href="{{ route('account.show', ['id' => $user->user_id]) }}" style="text-decoration: none; color: inherit;">{{ $user->user_email }}</a></td>
            <td><a href="{{ route('account.show', ['id' => $user->user_id]) }}" style="text-decoration: none; color: inherit;">{{ $user->created_at }}</a></td>
        </tr>
    @endforeach


@endsection