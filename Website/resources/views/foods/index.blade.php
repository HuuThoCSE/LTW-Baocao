@extends('main')

@section('title')
Quản lý thức ăn
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
<h1>List of Foods</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
    <li class="breadcrumb-item">Food</li>
    <li class="breadcrumb-item">List Food</li>
    </ol>
</nav>
</div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-clipboard-plus"></i>
                            <span class="ms-2">Add Food</span>
                        </button>
                    </div>

                    <div class='card-body'>
                        <table class="table datatable table-striped table-bordered table-hover mt-3">
                            <thead class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã thức ăn</th>
                                    <th>Tên thức ăn (tiếng việt)</th>
                                    <th>Tên thức ăn (tiếng anh)</th>
                                    <th>Type</th>
                                    <th>Thời hạn sử dụng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($foods as $food)
                                <tr>
                                    <td style='text-align: center'>{{ $food->food_id }}</td>
                                    <td style='text-align: center'>{{ $food->food_code }}</td>
                                    <td>{{ $food->food_name_vn }}</td>
                                    <td>{{ $food->food_name_el }}</td>
                                    <td>{{ $food->type_food_name_vn}}</td>
                                    <td>{{ $food->expiry_date }}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <form action="{{ route('foods.del', $food->food_id) }}" method="POST" style="display:inline;">
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
                                            data-bs-target="#udpModal{{$food->food_id}}" >
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
            <form method="POST" action="{{ route('foods.add') }}">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Food</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="food_code" class="form-label">Food Code:</label>
                        <input type="text" name="food_code" class="form-control" placeholder="Enter food code" id="food_code">
                    </div>
                    <div class="form-group mb-3">
                        <label for="food_name_vn" class="form-label">Food Name (Vietnamese):</label>
                        <input type="text" name="food_name_vn" class="form-control" placeholder="Enter Vietnamese name" id="food_name_vn">
                    </div>
                    <div class="form-group mb-3">
                        <label for="food_name_el" class="form-label">Food Name (English):</label>
                        <input type="text" name="food_name_el" class="form-control" placeholder="Enter English name" id="food_name_el">
                    </div>
                    <div class="form-group mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date:</label>
                        <input type="text" name="expiry_date" class="form-control" placeholder="Enter expiry date" id="expiry_date">
                    </div>
                    <div class="form-group mb-3">
                        <label for="type_food_id" class="form-label">Type of Food:</label>
                        <select name="type_food_id" id="type_food_id" class="form-control">
                            <option value="">Select Type of Food</option>
                            @foreach ($type_foods as $type)
                                <option value="{{ $type->type_food_id}}">{{ $type->type_food_name_vn }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Food</button>
                </div>
            </form>
        </div>
    </div>
</div>


@foreach($foods as $food)
    <div class="modal fade" id="udpModal{{$food->food_id}}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('foods.udp', ['id' => $food->food_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Update Food Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="goat_name{{ $food->food_id}}" class="form-label">Food Code</label>
                            <input type="text" id="goat_name{{ $food->food_id }}" name="food_code" value="{{ $food->food_code }}" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="food_name_vn{{ $food->food_id }}" class="form-label">Food Name (Vietnamese)</label>
                            <input type="text" id="food_name_vn{{ $food->food_id }}" name="food_name_vn" value="{{ $food->food_name_vn }}" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="food_name_el{{ $food->food_id }}" class="form-label">Food Name (English)</label>
                            <input type="text" id="food_name_el{{ $food->food_id }}" name="food_name_el" value="{{ $food->food_name_el }}" class="form-control">
                        </div>

                        <!-- Dropdown to select food type -->
                        <div class="form-group mb-3">
                        <label for="type_food_id" class="form-label">Type of Food:</label>
                        <select name="type_food_id" id="type_food_id" class="form-control">
                            <option value="">Select Type of Food</option>
                            @foreach ($type_foods as $type)
                                <option value="{{ $type->type_food_id}}">{{ $type->type_food_name_vn }}</option>
                            @endforeach
                        </select>
                    </div>

                        <div class="form-group mb-3">
                            <label for="expiry_date{{ $food->food_id }}" class="form-label">Expiry Date</label>
                            <input type="text" id="expiry_date{{ $food->food_id }}" name="expiry_date" value="{{ $food->expiry_date }}" class="form-control">
                        </div>

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


@endsection
