@extends('main')

@section('title', 'Manage Areas')

@section('contents')
<div class="container mt-4">
    <!-- Tiêu đề -->
    <h1 class="text-center mb-4">Manage Areas</h1>
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
    <button class="btn btn-primary mb-3 mt-4 d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addAreaModal">
        <i class="bi bi-clipboard-plus"></i>
        <span class="ms-2">Add Area</span>
    </button>

    <!-- Bảng danh sách các khu vực -->
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr align="center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th colspan="2">Operations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($areas as $area)
                <tr align="center">
                    <td>{{ $area->id }}</td>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->description }}</td>
                    <td>{{ $area->created_at }}</td>
                    <td>{{ $area->updated_at }}</td>
                    <td>
                        <!-- Nút xóa -->
                        <form action="{{ route('listarea.del', $area->id) }}" method="POST" style="display:inline;">
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
                        <button class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#udpModal{{$area->id}}">
                            <i class="bi bi-pencil-square"></i>
                            <span class="ms-2">Update</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Form thêm mới -->
    
    

    Modal thêm mới
    <div class="modal fade" id="addAreaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('listarea.add') }}">
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
    @foreach($areas as $area)
    <div class="modal fade" id="udpModal{{$area->id}}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="updateForm{{$area->id}}" method="POST" action="{{ route('listarea.udp', ['id' => $area->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Area</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $area->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description:</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ $area->description }}</textarea>
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
