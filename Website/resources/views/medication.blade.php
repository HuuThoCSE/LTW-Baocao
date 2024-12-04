@extends('main')

@section('title')
Quản lý thuốc
@endsection

@section('content')

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
            <th colspan="2">Thao tác</th>
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
            <td>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#udpModal">Update</button>
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

<div class="modal fade" id="udpModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Basic Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal-->

@endsection
