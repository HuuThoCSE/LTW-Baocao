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
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td align='center'>
                <form action="{{ route('account.del', $user->id) }}" method="POST" style="display:inline;">
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


@endsection