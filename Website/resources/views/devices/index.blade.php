@extends('main')

@section('title', 'List of Device')

@section('content')

@if($errors->has('device_name'))
    <div class="alert alert-danger">{{ $errors->first('device_name') }}</div>
@endif

@if($errors->has('type_device_id'))
    <div class="alert alert-danger">{{ $errors->first('type_device_id') }}</div>
@endif

@if (session('error'))
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
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">{{ __('messages.action') }}</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @foreach($devices as $device)
                        <tr class="text-center">
                            <td>{{ $device->device_id }}</td>
                            <td onclick="window.location='{{ route('devices.show', ['id' => $device->device_id]) }}'">{{ $device->device_name }}</td>
                            <td>{{ $device->type_device_name }}</td>
                            <td>
                                @if($device->status === 'Active')
                                    <span class="badge rounded-pill bg-success">{{ $device->status }}</span>
                                @elseif($device->status === 'Inactive')
                                    <span class="badge rounded-pill bg-danger">{{ $device->status }}</span>
                                @elseif($device->status === 'Pending')
                                    <span class="badge rounded-pill bg-warning text-dark">{{ $device->status }}</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary">{{ $device->status }}</span>
                                @endif
                            </td>
                            <td class="d-flex justify-content-center align-items-center">

                                <form action="{{ route('devices.del', $device->type_device_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');"
                                            class="btn btn-danger btn-sm d-flex align-items-center">
                                        <i class="ri-delete-bin-5-line"></i>
                                        <span class="ms-2">Delete</span>
                                    </button>
                                </form>

                                <button class="btn btn-success btn-sm ms-2"
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

<!-- Add Device Modal -->
<div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeviceModalLabel">Add New Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Device Form -->
                <form action="{{ route('devices.add') }}" method="POST">

                    @csrf
                    <div class="mb-3">
                        <label for="device_name" class="form-label">Device Name</label>
                        <input type="text" class="form-control" id="device_name" name="device_name" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="type_device_id" class="form-label">Type Device:</label>
                        <select id="type_device_id" name="type_device_id" class="form-select">
                            <option value="" disabled selected >Select Type Device</option>
                            @foreach($type_devices as $type_device)
                                <option value="{{ $type_device->type_device_id }}">{{ $type_device->type_device_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addButton">Add Device</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
