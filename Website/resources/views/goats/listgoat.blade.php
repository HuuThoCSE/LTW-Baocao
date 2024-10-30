@extends('main')

@section('title')
Danh sách dê
@endsection

@section('contents')
<h1>List of Goats</h1>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr align='center'>
                <th>Id</th>
                <th>Name</th>
                <th>Age</th>
                <th>Origin</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
     
        @foreach($goats as $goat)
            <tr onclick="window.location='{{ route('goats.show', ['id' => $goat->goat_id]) }}'" style="cursor:pointer;">
                <td>{{ $goat->goat_id }}</td>
                <td>{{ $goat->goat_name }}</td>
                <td>{{ $goat->goat_age }}</td>
                <td>{{ $goat->origin }}</td>
                <td align='center'>
                        <form action="{{ route('goats.del', $goat->goat_id) }}" method="POST" style="display:inline;">
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
       
    </table>
</div>

<!-- Form to add a new farm -->
<form action="{{ route('goats.add') }}" method="POST">
    @csrf
    <table class="table table-border">
        <tr>
            <td><input type="text" name="goat_name" class="form-control" placeholder="Goat Name"></td>
            <td><input type="text" name="goat_age" class="form-control" placeholder="Goat Age"></td>
            <td>
                <select name="origin" class="form-control">
                    <option value="origin">Select Origin</option>
                    <option value="imported">imported</option>
                    <option value="born_on_farm">born_on_farm</option>
                </select>
            </td>    
        </tr>
    </table>
    <input type="submit" value="Add goat" class="btn btn-primary">
</form>

<!-- Madol Update -->
<div class="modal fade" id="udpModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Update Goat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form id="updateForm" >
                    <div class="form-group">
                        <label for="goat_name" class="col-form-label">Name:</label>
                        <input type="text" name="goat_name" class="form-control" placeholder="Goat Name">
                    </div>
                    <div class="form-group">
                        <label for="goat_age" class="col-form-label">Age:</label>
                        <td><input type="text" name="goat_age" class="form-control" placeholder="Goat Age"></td>
                    </div>
                    <div class="form-group">
                        <label for="origin" class="col-form-label">Origin:</label>
                        <select name="origin" class="form-control">
                            <option value="origin">Select Origin</option>
                            <option value="imported">imported</option>
                            <option value="born_on_farm">born_on_farm</option>
                        </select>
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


@endsection
