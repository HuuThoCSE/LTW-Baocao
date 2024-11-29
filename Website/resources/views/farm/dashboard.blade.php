@extends('main')

@section('title', 'Bảng điều khiển')

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Farm</a></li>
            <li class="breadcrumb-item active">List Farm</li>
        </ol>
    </nav>
</div>

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
    

<!-- Danh sách các trang trại -->
<div class="container mt-5">
    <h2 class="text-center mb-4">List of Farms</h2>
</div>
    <button class="btn btn-primary mb-3 mt-4 d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addFarmModal">
        <i class="bi bi-plus-circle"></i>
        <span class="ms-2">Add Farm</span>
    </button>
<div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Owner</th>
                <th colspan="2">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($farms as $farm)
            <tr class="text-center">
                <td>{{ $farm->farm_id }}</td>
                <td>{{ $farm->farm_name }}</td>
                <td>{{ $farm->location }}</td>
                <td>{{ $farm->owner_id }}</td>
                <td>
                    <!-- Nút xóa -->
                    <form action="{{ route('listfarm.del', $farm->farm_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="ri-delete-bin-5-line"></i>
                            <span class="ms-1">Delete</span>
                        </button>
                    </form>
                </td>
                <td>
                    <!-- Nút cập nhật -->
                    <button class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#udpModal{{$farm->farm_id}}">
                        <i class="bi bi-pencil-square"></i>
                        <span class="ms-1">Update</span>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal cập nhật -->
@foreach($farms as $farm)
<div class="modal fade" id="udpModal{{$farm->farm_id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded">
            <form method="POST" action="{{ route('listfarm.udp', ['farm_id' => $farm->farm_id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Update Farm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="farm_name" class="form-label">Farm Name:</label>
                        <input type="text" name="farm_name" class="form-control" value="{{ $farm->farm_name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="location" class="form-label">Location:</label>
                        <select name="location" class="form-control">
                            <option value="Province" {{ $farm->location == 'Province' ? 'selected' : '' }}>Select Province</option>
                            <option value="Vinh Long Province" {{ $farm->location == 'Vinh Long Province' ? 'selected' : '' }}>Vinh Long Province</option>
                            <option value="Tien Giang Province" {{ $farm->location == 'Tien Giang Province' ? 'selected' : '' }}>Tien Giang Province</option>
                            <option value="Ben Tre Province" {{ $farm->location == 'Ben Tre Province' ? 'selected' : '' }}>Ben Tre Province</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="owner_id" class="form-label">Owner ID:</label>
                        <input type="text" name="owner_id" class="form-control" value="{{ $farm->owner_id }}" required>
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

<!-- Form thêm mới -->


<!-- Modal Thêm Farm -->
<div class="modal fade" id="addFarmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded">
            <form action="{{ route('listfarm.add') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Farm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="farm_name" class="form-label">Farm Name:</label>
                        <input type="text" name="farm_name" class="form-control" placeholder="Enter farm name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="location" class="form-label">Location:</label>
                        <textarea name="location" class="form-control" placeholder="Enter location" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="owner_id" class="form-label">Owner ID:</label>
                        <input type="text" name="owner_id" class="form-control" placeholder="Enter owner ID" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Farm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Thông báo -->
@if (session('success'))
<div class="alert alert-success mt-3 rounded shadow-sm">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger mt-3 rounded shadow-sm">
    {{ session('error') }}
</div>
@endif

@endsection
