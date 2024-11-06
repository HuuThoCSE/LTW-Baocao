@extends('main')

@section('title')
Quản lý thức ăn
@endsection

@section('contents')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-striped">
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
            <td>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#udpModal">Update</button>
            </td>
        <tr>
    @endforeach
</table>

<form action="{{ route('food.add') }}" method="POST">
    @csrf
    <h1>Thêm thức ăn</h1>
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




@endsection