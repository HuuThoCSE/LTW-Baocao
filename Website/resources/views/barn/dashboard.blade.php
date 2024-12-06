@extends('main')

@section('title', 'Manage Barns')

@section('content')
<style>
        /
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
<h1>List of Barns</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
    <li class="breadcrumb-item">Location</li>
    <li class="breadcrumb-item">List Barn</li>
    
    </ol>
</nav>
</div><!-- End Page Title --> 
<div class="container mt-4">
    <!-- Table heading -->
   

    <button class="btn btn-primary mb-3 mt-4 d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addBarnModal">
        <i class="bi bi-clipboard-plus"></i>
        <span class="ms-2">Add Barn </span>
    </button>

    <!-- Barns Table -->
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr align="center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th colspan="2">Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barns as $barn)
                <tr align="center" onclick="window.location.href='{{ route('barn.show', $barn->barn_id) }}'">
                    <td>{{ $barn->barn_id }}</td>
                    <td>{{ $barn->barn_name }}</td>
                    <td>{{ $barn->description }}</td>
                    <td>
                        <form action="{{ route('barn.del', $barn->barn_id) }}" method="POST" style="display:inline;">
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
                        <button class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal"
                                data-bs-target="#udpModal{{$barn->barn_id}}" onclick="event.stopPropagation();">
                            <i class="bi bi-pencil-square"></i>
                            <span class="ms-2">Update</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal for updating barns -->
    @foreach($barns as $barn)
    <div class="modal fade" id="udpModal{{$barn->barn_id}}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="updateForm{{$barn->barn_id}}" method="POST" action="{{ route('barn.udp', ['id' => $barn->barn_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Barn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="barn_name" class="form-label">Name:</label>
                            <input type="text" name="barn_name" class="form-control" value="{{ $barn->barn_name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ $barn->description }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Add New BarnModel Form -->

    <!-- Modal for adding a new barn -->
    <div class="modal fade" id="addBarnModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('barn.add') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Barn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="barn_name" class="form-label">Barn Name:</label>
                            <input type="text" name="barn_name" class="form-control" placeholder="Enter barn name" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="zone_id" class="form-label">Zone:</label>
                            <select id="zone_id" name="zone_id" class="form-select">
                                <option value="" >Select Zone</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->zone_id }}">{{ $zone->zone_name }}</option>
                                @endforeach
                            </select>
                        </div>
                       

                        <!-- Đoạn mã cho Area được ẩn ban đầu -->
                        <div class="form-group mb-3">
                            <label for="zone_id" class="form-label">Area:</label>
                            <select id="area_id" name="area_id" class="form-select">
                                <option value="" >Select Area</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area->area_id }}">{{ $area->area_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Barn</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
