@extends('main')

@section('title')
Quản lý loại thức ăn
@endsection

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
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="pagetitle">
<h1>Food List Type</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
    <li class="breadcrumb-item">Food</li>
    <li class="breadcrumb-item">Food List Type</li>
    </ol>
</nav>
</div> <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-clipboard-plus"></i>
                            <span class="ms-2">Add Type Food</span>
                        </button>
                    </div>

                    <div class='card-body'>
                        <table class="table datatable table-striped table-bordered table-hover mt-3">
                            <thead class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã loại thức ăn</th>
                                    <th>Tên loai thức ăn (tiếng việt)</th>
                                    <th>Tên loại thức ăn (tiếng anh)</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($type_foods as $type_food)
                                <tr>
                                    <td style='text-align: center'>{{ $type_food->type_food_id }}</td>
                                    <td style='text-align: center'>{{ $type_food->type_food_code }}</td>
                                    <td>{{ $type_food->type_food_name_vn }}</td>
                                    <td>{{ $type_food->type_food_name_el }}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <form action="{{ route('typefoods.del', $type_food->type_food_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm d-flex align-items-center"
                                                onclick="return confirm('Are you sure you want to delete this item?');" >
                                                <i class="ri-delete-bin-5-line"></i>
                                                <span class="ms-2">Delete</span>
                                            </button>
                                        </form>

                                        <button class="btn btn-success btn-sm d-flex align-items-center ms-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#udpModal{{$type_food->type_food_id}}" >
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="ms-2">Update</span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('typefoods.add') }}">
                        @csrf
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" >Add New Food</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <!-- Form fields -->
                            <div class="form-group mb-3">
                                <label for="type_food_code" class="form-label">Food type code:</label>
                                <input type="text" name="type_food_code" class="form-control" placeholder="Enter farm name" id="food_type_code">
                                <span class="text-danger error-farm_name"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label class="type_food_name_vn" for="inp_email">Food type name vn:</label>
                                <input type="text" name="type_food_name_vn" id="type_food_name_vn" class="form-control" placeholder="Tên loại thức ăn (Vietnamese)">
                            </div>

                            <div class="form-group mb-3">
                                <label class="type_food_name_el" for="inp_email">Food type name el:</label>
                                <input type="text" name="type_food_name_el" id="type_food_name_el" class="form-control" placeholder="Tên loại thức ăn (English)">
                            </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Farm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @foreach($type_foods as $type_food)
    <div class="modal fade" id="udpModal{{$type_food->type_food_id}}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('typefoods.udp', ['id' => $type_food->type_food_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Food Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                            <div class="form-group mb-3">
                                <label for="goat_name{{ $type_food->type_food_id }}" class="form-label">Food type code</label>
                                <input type="text" id="goat_name{{ $type_food->type_food_id }}" name="type_food_code" value="{{ $type_food->type_food_code }}" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="food_name_vn{{ $type_food->type_food_id }}" class="form-label">Food name vn</label>
                                <input type="text" id="type_food_name_vn{{ $type_food->type_food_id }}" name="type_food_name_vn" value="{{ $type_food->type_food_name_vn }}" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="food_name_el{{ $type_food->type_food_id }}" class="form-label">Food name el</label>
                                <input type="text" id="type_food_name_el{{ $type_food->type_food_id }}" name="type_food_name_el" value="{{ $type_food->type_food_name_el }}" class="form-control">
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

