@extends('main')

@section('title')

@endsection

@section('contents')
<h1>List of Farm</h1>

<!-- Table displaying list of farms -->
<div class="table-responsive">
    <table class="table table-bordered" style="border-radius: 10px; overflow: hidden">
        <thead >
            <tr align='center' >
                <th>ID</th>
                <th>Name</th>
                <th>description</th>
                <th>created_at</th>
                <th>updated_at</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
                <tr align='center'>
                    <td>{{ $area->area_id }}</td>
                    <td>{{ $area->area_name }}</td>
                    <td>{{ $area->description }}</td>
                    <td>{{ $area->created_at }}</td>
                    <td>{{ $area->updated_at }}</td>
                    <td text-align='center'>
                        <form action="{{ route('listarea.del', $area->area_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick=" return confirm('Are you sure you want to delete this item?');" class="btn btn-danger d-flex align-items-center">
                                Delete
                                <div class="icon" style="margin-left: 10px;">
                                    <i class="ri-delete-bin-5-line"></i>
                                </div>
                            </button>
                        </form>
                    </td>
                    <td align='center'>
                        <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#udpModal{{$area->area_id}}" >
                        Update               
                            <div class="icon" style="margin-left: 10px;">
                                <i class="bi bi-arrow-clockwise"></i>
                            </div>
                        </button>
                    </td>
                </tr>     
            @endforeach
        </tbody>   
    </table>
</div>

<h2><br>New Area...</h2>

            @foreach($areas as $area)
            <div class="modal fade" id="udpModal{{$area->area_id}}" tabindex="-1">
                <div class="modal-dialog modal-small">
                <div class="modal-content">
                <form id="updateForm{{$area->area_id}}" method="POST" action="{{ route('listarea.udp', ['area_id' => $area->area_id] )}}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                    <h5 class="modal-title">Update Farm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Description:</label>
                                    <input type="text" name="description" class="form-control" value="{{$area->area_name}}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="created_at" class="col-form-label">Created_at:</label>
                                    <input type="text" name="created_at" class="form-control" value="{{$area->created_at}}">
                                </div>
                                <div class="form-group">
                                    <label for="updated_at" class="col-form-label">Updated_at:</label>
                                    <input type="text" name="updated_at" class="form-control" value="{{$area->created_at}}">
                                </div>
                        
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="submit" value="Save changes">
                    </div>
                </div>
                </form>
                
                </div>
            </div>
            @endforeach

<!-- Hàm cập nhật dữ liệu khi nhấn vào nut update -->

@endsection