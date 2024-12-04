@extends('main')

@section('title')
Register User
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-4">
    <form action="{{ route('user.add') }}" method="POST" class="bg-light p-4 rounded shadow">
        @csrf
        <h4 class="mb-3">Điền thông tin vào form đăng ký</h4>

        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" id="" class="form-control" required placeholder="Tên truy cập">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="" class="form-control" required placeholder="Email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="" class="form-control" required placeholder="Mật khẩu">
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Hoàn thành</button>
        </div>
    </form>


</div>
@endsection
