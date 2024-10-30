@extends('main')

@section('title')
Bảng điều khiển
@endsection

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>

<h1>Thông tin chi tiết của dê: {{ $goat->goat_name }}</h1>
<div class="card mb-3">
    <p><strong>Tên:</strong> {{ $goat->goat_name }}</p>
    {{-- <p><strong>Tuổi:</strong> {{ $goat->goat_age }} năm</p> --}}
    {{-- <p><strong>Giống:</strong> {{ $goat->goat_breed }}</p> --}}
    {{-- <p><strong>Cân nặng:</strong> {{ $goat->goat_weight }} kg</p> --}}
    {{-- <p><strong>Tình trạng sức khỏe:</strong> {{ $goat->health_status }}</p> --}}
    {{-- <p><strong>Trạng thái tiêm chủng:</strong> {{ $goat->vaccination_status }}</p> --}}
</div>
<a href="{{ route('goats.listgoat') }}" class="btn btn-primary">Quay lại danh sách dê</a>

<!-- End Page Title -->


@endsection