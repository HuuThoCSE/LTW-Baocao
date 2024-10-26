@extends('main')

@section('title')
Quản lý thuốc
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
            <th>Mã thuốc</th>
            <th>Tên thuốc</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($medications as $medication)
       <tr>
            <td style='text-align: center'>{{ $medication->id }}</td>
            <td style='text-align: center'>{{ $medication->medication_code }}</td>
            <td>{{ $medication->medication_name }}</td>
            <td align='center'>
                <form action="{{ route('medication.del', $medication->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</button>
                </form>
            </td>
        <tr>
    @endforeach
</table>

<form action="{{ route('medication_add') }}" method="POST">
    @csrf
    <h1>Thêm thuốc</h1>
    <label for="">Mã thuốc</label>
    <input type="text" name="medication_code" id="" class="form-control"> <br>
    <label for="">Tên thuốc:</label>
    <input type="text" name="medication_name" id="" class="form-control"><br>
    <input type="submit" value="Thêm thuốc" class="btn btn-primary">
</form>
@endsection