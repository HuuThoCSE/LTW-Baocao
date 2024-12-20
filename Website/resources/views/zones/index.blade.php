@extends('main')

@section('title', 'List of Zones')

@section('content')
<style>

    /* Add hover effect for buttons */
    .btn:hover {
        transform: scale(1.1);
        transition: transform 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success:hover {
        background-color: #218838;
    }
</style>
<div class="pagetitle">
<h1>List of Zorns</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">Location</li>
    <li class="breadcrumb-item">List Zone</li>
    </ol>
</nav>
</div><!-- End Page Title -->

<!-- Button to trigger the Add Zone modal -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header">
                        <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addZoneModal">
                            <i class="bi bi-clipboard-plus"></i>
                            <span class="ms-2">Add Zone</span>
                        </button>
                    </div>

                    <div class='card-body'>
                        <table class="table datatable table-striped table-bordered table-hover mt-3">
                            <thead class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th colspan="2">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($zones as $zone)
                                <tr class="text-center">
                                    <td>{{ $zone->zone_id }}</td>
                                    <td>{{ $zone->zone_name }}</td>
                                    <td>{{ $zone->description }}</td>
                                    <td>
                                        <!-- Nút xóa -->
                                        <form action="{{ route('zones.del', $zone->zone_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center"
                                                onclick="return confirm('Are you sure you want to delete this zone?');">
                                                <i class="ri-delete-bin-5-line"></i>
                                                <span class="ms-2">Delete</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Nút cập nhật -->
                                        <button class="btn btn-success btn-sm d-flex align-items-center"
                                            data-bs-toggle="modal"
                                            data-bs-target="#udpModal{{$zone->zone_id}}">
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="ms-2">Update</span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

    <!-- Modal cập nhật Zone -->
    @foreach($zones as $zone)
    <div class="modal fade" id="udpModal{{$zone->zone_id}}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('zones.udp', ['id' => $zone->zone_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Zone</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="zone_name" class="form-label">Zone Name:</label>
                            <input type="text" name="zone_name" class="form-control" value="{{ $zone->zone_name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" required>{{ $zone->description }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal for adding a new zone -->
    <div class="modal fade" id="addZoneModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('zones.add') }}">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Zone</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="zone_name" class="form-label">Zone Name:</label>
                            <input type="text" name="zone_name" class="form-control" placeholder="Enter zone name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" placeholder="Enter description" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="farm_id" class="form-label">Farm ID:</label>
                            <input type="number" name="farm_id" class="form-control" placeholder="Enter farm ID" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Zone</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Thông báo -->
    @if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
    @endif

@endsection
