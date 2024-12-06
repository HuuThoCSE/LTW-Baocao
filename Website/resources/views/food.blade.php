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
<button id="newFoodBtn" class="btn btn-primary" onclick="showAddFoodForm()">New Food +</button>
<div id="addFoodForm" style="display: none;">
    <form action="{{ route('food.add') }}" method="POST">
        @csrf
        <h2>New Food</h2>
        <label for="">Mã thức ăn</label>
        <input type="text" name="food_code" id="" class="form-control"> <br>
        <label for="">Tên thức ăn (tiếng việt):</label>
        <input type="text" name="food_name_vn" id="" class="form-control"><br>
        <label for="">Tên thức ăn (tiếng anh):</label>
        <input type="text" name="food_name_el" id="" class="form-control"><br>
        <label for="">Thời hạn sử dụng:</label>
        <input type="text" name="expiry_date" id="" class="form-control"><br>
        <input type="submit" value="Thêm thức ăn" class="btn btn-primary">
    </form>
</div>
<script>
        function showAddFoodForm() {
            // Ẩn nút New GoatModel và hiện form Add GoatModel
            document.getElementById('newFoodBtn').style.display = 'none';
            document.getElementById('addFoodForm').style.display = 'block';
        }
    </script>
            @foreach($foods as $food)
            <div class="modal fade" id="udpModal{{$food->id}}" tabindex="-1">
                <div class="modal-dialog modal-small">
                <div class="modal-content">
                <form id="updateForm{{$food->id}}" method="POST" action="{{ route('foods.udp', ['id' => $food->id] )}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                    <h5 class="modal-title">Update Food</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="farm_code" class="col-form-label">Mã thức ăn:</label>
                        <input type="text" name="farm_code" class="form-control" placeholder="Mã thức ăn">
                    </div>
                    <div class="form-group">
                        <label for="food_name_vn" class="col-form-label">Namefood_Vietnamese:</label>
                        <td><input type="text" name="food_name_vn" class="form-control" placeholder="Vietnamese"></td>
                    </div>
                    <div class="form-group">
                        <label for="food_name_el" class="col-form-label">Namefood_English:</label>
                        <td><input type="text" name="food_name_el" class="form-control" placeholder="English"></td>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date" class="col-form-label">Thời hạn sử dụng:</label>
                        <td><input type="text" name="expiry_date" class="form-control" placeholder="Thời hạn sử dụng"></td>
                    </div>

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="submit" value="Save changes">
                    </div>
                    </div>
                </div>
                </form>

                </div>
            </div>
            @endforeach
@endsection
