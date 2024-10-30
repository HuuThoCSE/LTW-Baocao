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
                <th>Code</th>
                <th>Tên</th>
                <th>Tuổi</th>
                <th>Origin</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
     
        @foreach($listgoats as $goat)
        
            <tr>
                <td>{{ $goat->goat_id }}</td>
                <td>{{ $goat->goat_name }}</td>
                <td>{{ $goat->goat_age }}</td>
                <td>{{ $goat->origin }}</td>
            </tr>
    
            
        @endforeach
       
    </table>
</div>
@endsection
