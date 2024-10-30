@extends('main')

@section('title', 'Bảng điều khiển')

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Farm</a></li>
            <li class="breadcrumb-item active"><a href="components-alerts.html">List Farm</a></li>
        </ol>
    </nav>
</div> <!-- End Page Title -->

<h1>List of Farm</h1>

<!-- Table displaying list of farms -->
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr align='center'>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Owner</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($farms as $farm)
                <tr align='center'>
                    <td>{{ $farm->farm_id }}</td>
                    <td>{{ $farm->farm_name }}</td>
                    <td>{{ $farm->location }}</td>
                    <td>{{ $farm->owner_id }}</td>
                    <td align='center'>
                        <form action="{{ route('listfarm.del', $farm->farm_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td align='center'>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#udpModal">Update</button>
                    </td>
                </tr>     
            @endforeach
        </tbody>   
    </table>
</div>

<div class="modal fade" id="udpModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Update Farm</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form id="updateForm" >
                    <div class="form-group">
                        <label for="name" class="col-form-label">Name:</label>
                        <input type="text" name="farm_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="location" class="col-form-label">Location:</label>
                        <select name="location" class="form-control">
                            <option value="Area">Select Area</option>
                            <option value="Area A">Area A</option>
                            <option value="Area B">Area B</option>
                            <option value="Area C">Area C</option>
                            <option value="Area D">Area D</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="owner_id" class="col-form-label">Owner:</label>
                        <input type="text" name="owner_id" class="form-control">
                    </div>
            </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
</div><!-- End Basic Modal-->

<!-- Form to add a new farm -->
<form action="{{ route('listfarm.add') }}" method="POST">
    @csrf
    <table class="table table-border">
        <tr>
            <td><input type="text" name="farm_name" class="form-control" placeholder="Farm Name"></td>
            <td>
                <select name="location" class="form-control">
                    <option value="Area">Select Area</option>
                    <option value="Area A">Area A</option>
                    <option value="Area B">Area B</option>
                    <option value="Area C">Area C</option>
                    <option value="Area D">Area D</option>
                </select>
            </td>
            <td><input type="text" name="owner_id" class="form-control" placeholder="Owner ID"></td>
        </tr>
    </table>
    <input type="submit" value="Add farm" class="btn btn-primary">
</form>



@endsection
