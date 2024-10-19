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
                    <tr>
                        
                        <th>Name</th>
                        <th>Location</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($farms as $farm)
                        <tr>
                            
                            <td>{{ $farm->farm_name }}</td>
                            <td>{{ $farm->location }}</td>
                            <td>{{ $farm->owner_id }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                        <td><input type="text"></td>
                    </tr>
                </tbody>
                
            </table>
            
        </div>



@endsection