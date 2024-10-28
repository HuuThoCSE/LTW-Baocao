@extends('main')

@section('title')
Register User
@endsection

@section('contents')
<div class="pagetitle">
    <h1>Register User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
            <li class="breadcrumb-item active">Register User</li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <form action="{{ route('admin.register') }}" method="POST" class="bg-light p-4 rounded shadow">
        @csrf
        <h4 class="mb-3">Điền thông tin vào form đăng ký</h4>

        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Hoàn thành</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection  
