@extends('main')

@section('title')
Bảng điều khiển - Trang trại dê thông minh
@endsection

@section('content')
<div class="pagetitle">
    <h1>Trang Trại Dê Thông Minh</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Quản lý trang trại</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <!-- Các chức năng chính -->
        <div class="col-lg-12">
            <div class="row">
                <!-- Quản lý đàn dê -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Quản lý đàn dê</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clipboard-data"></i>
                                </div>
                                <div class="ps-3">
                                    <a href="{{ route('goats.index') }}" class="btn btn-primary">Xem chi tiết</a>
                                    <p class="text-muted small pt-2">Thông tin về đàn dê</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quản lý thức ăn -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Quản lý thức ăn</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-basket"></i>
                                </div>
                                <div class="ps-3">
                                    <a href="{{ route('foods.index') }}" class="btn btn-success">Xem chi tiết</a>
                                    <p class="text-muted small pt-2">Kiểm soát thức ăn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quản lý thuốc và vaccine -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title">Thuốc & Vaccine</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-capsule"></i>
                                </div>
                                <div class="ps-3">
                                    <a href="#" class="btn btn-warning">Xem chi tiết</a>
                                    <p class="text-muted small pt-2">Quản lý thuốc và vaccine</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin nhanh -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Hướng dẫn sử dụng</h5>
                    <div class="alert alert-info">
                        <h4 class="alert-heading">Chào mừng đến với hệ thống quản lý trang trại dê thông minh!</h4>
                        <p>Hệ thống này giúp bạn:</p>
                        <ul>
                            <li>Theo dõi thông tin chi tiết về đàn dê</li>
                            <li>Quản lý thức ăn và vaccine</li>
                            <li>Theo dõi sức khỏe đàn dê</li>
                            <li>Nhận thông báo quan trọng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông báo -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thông báo mới</h5>
                    <div class="activity">
                        <div class="activity-item d-flex">
                            <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                            <div class="activity-content">
                                Cập nhật phiên bản mới nhất của hệ thống
                            </div>
                        </div>
                        <div class="activity-item d-flex">
                            <i class="bi bi-circle-fill activity-badge text-danger align-self-start"></i>
                            <div class="activity-content">
                                Kiểm tra an toàn hệ thống định kỳ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
