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
    <button class="btn btn-primary mb-3 mt-4 d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addAccountModal">
        <i class="bi bi-plus-circle"></i>
        <span class="ms-2">Add Account</span>
    </button>
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


<!-- Form đăng ký -->

<div class="modal fade" id="addAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded">
            <form action="{{ route('user.add') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="user_name" class="form-label">Tên tài khoản:</label>
                        <input type="text" name="user_name" class="form-control" placeholder="Enter account name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="user_email" class="form-control" placeholder="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="owner_id" class="form-label">Password:</label>
                        <input type="password" name="user_password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="owner_id" class="form-label">Farm ID:</label>
                        <input type="number" name="farm_id" class="form-control" placeholder="Enter owner ID" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="owner_id" class="form-label">ID quyền:</label>
                        <input type="number" name="role_id" class="form-control" placeholder="Enter owner ID" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Account</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection