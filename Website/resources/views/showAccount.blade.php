@extends('main')

@section('title')
Thông tin tài khoản
@endsection

@section('contents')
<div class="pagetitle">
    <h1>Thông tin tài khoản</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Danh sách tài khoản</a></li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <h1 style="text-align: center;">Thông tin chi tiết tài khoản: {{ $user->name }}</h1>
    </div>

    <div class="card-body">
        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Tên:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Trang trại:</strong> {{ $user->farm_name }}</p>
    </div>
</div>
@endsection
