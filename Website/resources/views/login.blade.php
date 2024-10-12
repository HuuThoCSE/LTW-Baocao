@extends('main')

@section('title')
Đăng nhập
@endsection

@section('link')
<link rel="stylesheet" href="{{ asset('css/style1.css') }}">
@endsection

@section('content')
<div id="login">
        <form action="" id="form-login" method="POST">
            @csrf
            <h1 class="form-heading">Đăng nhập</h1>
            <div class="form-group">
                <input type="text" class="form-input" placeholder="Email đăng nhập" id="username" name="username">
            </div>
            <div class="form-group">
                <input type="password" class="form-input" placeholder="Mật khẩu" id="password" name="password">
            </div>
            <input type="submit" value="Đăng nhập" class="form-submit">
        </form>
    </div>
@endsection
