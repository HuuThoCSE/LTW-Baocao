@extends('main')

@section('title', 'Manage Areas')

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
    <h1>List of Area</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">List Area</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

    <section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header">
                    <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addBarnModal">
                        <i class="bi bi-clipboard-plus"></i>
                        <span class="ms-2">Add Area</span>
                    </button>
                </div>

                <!-- Bảng danh sách các khu vực -->
                <div class='card-body'>
                    <table class="table datatable table-striped table-bordered table-hover mt-3">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th colspan="2">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($farm_areas as $farm_area)
                            <tr>
                                <td>{{ $farm_area->area_id }}</td>
                                <td>{{ $farm_area->area_name }}</td>
                                <td>{{ $farm_area->description }}</td>
                                <td>{{ $farm_area->created_at }}</td>
                                <td>{{ $farm_area->updated_at }}</td>
                                <td>
                                    <!-- Nút xóa -->
                                    <form action="{{ route('areas.del', $farm_area->area_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');"
                                                class="btn btn-danger btn-sm d-flex align-items-center">
                                            <i class="ri-delete-bin-5-line"></i>
                                            <span class="ms-2">Delete</span>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Nút cập nhật -->
                                    <button class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#udpModal{{$farm_area->area_id}}">
                                        <i class="bi bi-pencil-square"></i>
                                        <span class="ms-2">Update</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- Form thêm mới -->



    <!-- # Modal thêm mới -->
    <div class="modal fade" id="addAreaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('areas.add') }}">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Area</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Area Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="zone_id" class="form-label">Zone:</label>
                            <select id="zone_id" name="zone_id" class="form-select" required>
                                <option value="" disabled selected>Select Zone</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->zone_id }}">{{ $zone->zone_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Area</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal cập nhật -->
    @foreach($farm_areas as $farm_area)
    <div class="modal fade" id="udpModal{{$farm_area->area_id}}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('areas.udp', ['area_id' => $farm_area->area_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Area</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="area_name" class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $farm_area->area_name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ $farm_area->description }}</textarea>
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
</div>



@endsection
