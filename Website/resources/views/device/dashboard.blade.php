@extends('main')

@section('title', 'List of Device')

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Devices</a></li>
            <li class="breadcrumb-item active"><a href="components-alerts.html">List of Device</a></li>
        </ol>
    </nav>
</div> <!-- End Page Title -->

<h1>List of Device</h1>

<!-- Table displaying list of farms -->
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr align='center'>
                <th>ID</th>
                <th>Name</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
                <tr align='center' onclick="window.location='{{ route('device.detail', ['id' => $device->device_id]) }}'">
                    <td>{{ $device->device_id }}</td>
                    <td>{{ $device->device_name }}</td>
                    <td align='center'>
                        <form action="{{ route('listfarm.del', $device->device_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td align='center'>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#udpModal{{$device->device_id}}" >Update</button>
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
