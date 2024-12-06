@extends('main')

@section('title', 'List of Device')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="pagetitle">
    <h1>List of Device</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">Devices</li>
            <li class="breadcrumb-item active">List of Device</li>
        </ol>
    </nav>
</div>

<section class="section">
<div class="row">
    <div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addDeviceModal">
                <i class="bi bi-clipboard-plus"></i>
                <span class="ms-2">Add Device</span>
            </button>
        </div>

        <!-- Table displaying list of farms -->
        <div class='card-body'>
            <table class="table datatable table-striped table-bordered table-hover mt-3">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Zone</th>
                        <th>Barn</th>
                        <th>Status</th>
                        <th colspan="2">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($devices as $device)
                        <tr onclick="window.location='{{ route('device.detail', ['id' => $device->device_id]) }}'">
                            <td>{{ $device->device_type_id }}</td>
                            <td>{{ $device->device_name }}</td>
                            <td>{{ $device->type_device_name }}</td>
                            <td>{{ $device->zone_id }}</td>
                            <td>{{ $device->barn_id }}</td>
                            <td>{{ $device->status }}</td>
                            <td >
                                <form action="{{ route('device.del', $device->device_type_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');"
                                            class="btn btn-danger btn-sm d-flex align-items-center">
                                        <i class="ri-delete-bin-5-line"></i>
                                        <span class="ms-2">Delete</span>
                                    </button>
                                </form>
                            </td>
                            <td >
                                <button class="btn btn-success btn-sm"  
                                data-bs-toggle="modal" 
                                data-bs-target="#udpModal{{$device->device_type_id}}" >
                                <i class="bi bi-pencil-square"></i>
                                Update
                            </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

<!-- Hàm cập nhật dữ liệu khi nhấn vào nut update -->

<!-- Form to add a new farm -->

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->has('farm_name'))
    <div class="alert alert-danger">{{ $errors->first('farm_name') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@endsection
