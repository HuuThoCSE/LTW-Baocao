@extends('main')

@section('title', 'List of Devices')

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Devices</a></li>
            <li class="breadcrumb-item active">List of Devices</li>
        </ol>
    </nav>
</div> <!-- End Page Title -->

<!-- Add Device Button -->
<div class="d-flex justify-content-between mb-3">
    <h1>List of Devices</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDeviceModal">
        <i class="bi bi-plus-circle"></i> Add Device
    </button>
</div>

<!-- Table displaying list of devices -->
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr align='center'>
                <th>ID</th>
                <th>Name</th>
                <th colspan="2">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
                <tr align='center' onclick="window.location='{{ route('device.detail', ['id' => $device->device_id]) }}'">
                    <td>{{ $device->device_id }}</td>
                    <td>{{ $device->device_name }}</td>
                    <td align='center'>
                        <form action="{{ route('device.del', $device->device_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td align='center'>
                        <!-- Update Button -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#udpModal{{$device->device_id}}">Update</button>
                    </td>
                </tr>     

                <!-- Update Modal -->
                <div class="modal fade" id="udpModal{{$device->device_id}}" tabindex="-1" aria-labelledby="udpModalLabel{{$device->device_id}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="udpModalLabel{{$device->device_id}}">Update Device</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Update Device Form -->
                                <form action="{{ route('device.upd', $device->device_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="device_name" class="form-label">Device Name</label>
                                        <input type="text" class="form-control" id="device_name" name="device_name" value="{{ $device->device_name }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                <form action="{{ route('device.add') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="device_name" class="form-label">Device Name</label>
                        <input type="text" class="form-control" id="device_name" name="device_name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Device</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success and Error Messages -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@endsection
