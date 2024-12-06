@extends('main')

@section('title')
Quản lý thức ăn
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-5">
    <h2 class="text-center mb-4">List of food</h2>
</div>
    <button class="btn btn-primary mb-3 mt-4 d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addFoodModal" id="btn-add">
        <i class="bi bi-plus-circle"></i>
        <span class="ms-2">Add Food</span>
    </button>

    <hr class="my-4">

<table class="table table-striped" style="border-radius: 20px; overflow: hidden; border: 2px solid black;">
    <thead>
        <tr style='text-align: center'>
            <th>ID</th>
            <th>Mã thức ăn</th>
            <th>Tên thức ăn (tiếng việt)</th>
            <th>Tên thức ăn (tiếng anh)</th>
            <th>Thời hạn sử dụng</th>
            <th colspan="2">Thao tác</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($foods as $food)
       <tr>
            <td style='text-align: center'>{{ $food->id }}</td>
            <td style='text-align: center'>{{ $food->food_code }}</td>
            <td>{{ $food->food_name_vn }}</td>
            <td>{{ $food->food_name_el }}</td>
            <td>{{ $food->expiry_date }}</td>
            <td align='center'>
                <form action="{{ route('food.del', $food->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</button>
                </form>
            </td>
            <td align='center'>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#udpModal{{$food->id}}" >Update</button>
            </td>
</tr>
    @endforeach
</table>
<div class="modal fade" id="addFoodModal" tabindex="-1" aria-labelledby="addFoodModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form method="POST" action="{{ route('food.add') }}">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addFoodModalLabel">Add New Food</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- General error message -->
                    <div id="error-alert" class="alert alert-danger d-none"></div>

                    <!-- Form fields -->
                    <div class="form-group mb-3">
                        <label for="food_code" class="form-label">food_code:</label>
                        <input type="text" name="food_code" class="form-control" placeholder="Enter farm name" id="food_code">
                        <span class="text-danger error-farm_name"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label class="food_name_vn" for="inp_email">Food_name_vn:</label>
                        <input type="text" name="food_name_vn" id="food_name_vn" class="form-control" placeholder="Tên thức ăn (Vietnamese)">
                    </div>

                    <div class="form-group mb-3">
                        <label class="food_name_el" for="inp_email">food_name_el:</label>
                        <input type="text" name="food_name_el" id="food_name_el" class="form-control" placeholder="Tên thức ăn (English)">
                    </div>
                    <div class="form-group mb-3">
                        <label class="expiry_date" for="inp_email">expiry_date:</label>
                        <input type="text" name="expiry_date" id="expiry_date" class="form-control" placeholder="Thời hạn dùng">
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Farm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($foods as $food)
<div class="modal fade" id="udpModal{{ $food->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('foods.udp', ['id' => $food->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Update Food Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card p-4 shadow-sm">
                        <div class="mb-3">
                            <label for="goat_name{{ $food->id }}" class="form-label">food_code</label>
                            <input type="text" id="goat_name{{ $food->id }}" name="food_code" value="{{ $food->food_code }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="food_name_vn{{ $food->id }}" class="form-label">Food_name_vn</label>
                            <input type="text" id="food_name_vn{{ $food->id }}" name="food_name_vn" value="{{ $food->food_name_vn }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="food_name_el{{ $food->id }}" class="form-label">Food_name_el</label>
                            <input type="text" id="food_name_el{{ $food->id }}" name="food_name_el" value="{{ $food->food_name_el }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date{{ $food->id }}" class="form-label">Expiry_date</label>
                            <input type="text" id="expiry_date{{ $food->id }}" name="expiry_date" value="{{ $food->expiry_date }}" class="form-control">
                        </div>
                    </div>

                

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

@endsection
