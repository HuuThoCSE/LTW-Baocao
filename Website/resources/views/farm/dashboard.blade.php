@extends('main')

@section('title')
Bảng điều khiển
@endsection

@section('contents')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Farm</a></li>
        <li class="breadcrumb-item active"><a href="components-alerts.html"></a>List Farm</li>
        </ol>
    </nav>
    
</div>End Page Title

    <h1>List of Farm </h1>
    <!-- Thêm bảng hiển thị danh sách dê -->
  
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr align='center'>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Owner</th>
                        <th colspan = "2">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($farms as $farm)
                        <tr>
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
                            <form action="{{ route('listfarm.put', $farm->farm_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Are you sure you want to update this item?');" class="btn btn-success" >Update</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>   
                       
                    </tr>
                    
                </tbody>
                
            </table>
            
        </div>

        <form action="{{ route('listfarm.add') }}" method="POST">
            @csrf
            <table class="table table-border">
                <tr>
                    <!-- <td><input type="text" name="farm_id" class="form-control"></td> -->
                    <td><input type="text" name="farm_name" class="form-control" ></td>
                    <!-- <td><input type="text" name="location"class="form-control" ></td> -->
                     <td><select name="location" id="location_id">
                        <option value="Area">Select Area</option>
                        <option value="Area A">Area A</option>
                        <option value="Area B">Area B</option>
                        <option value="Area C">Area C</option>
                        <option value="Area D">Area D</option>
                    </select></td>
                    <td><input type="text" name="owner_id" class="form-control" ></td>
                   
                </tr>
            </table>
            <input type="submit" value="Add farm" class="btn btn-primary" >
        </form>


@endsection