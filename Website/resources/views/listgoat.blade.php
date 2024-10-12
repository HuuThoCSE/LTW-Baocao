@extends('main')

@section('title')
Danh sách dê
@endsection

@section('content')
<h1>List of Goats</h1>
<table class="table">
    <tr>
        <th>Code</th>
        <th>Tên</th>
        <th>Tuổi</th>
        <th>Origin</th>
    </tr>
    <ul>
    @foreach($listgoats as $goat)
    
        <tr>
            <td>{{ $goat->goat_id }}</td>
            <td>{{ $goat->goat_name }}</td>
            <td>{{ $goat->goat_age }}</td>
            <td>{{ $goat->origin }}</td>
        </tr>
   
        
    @endforeach
    </ul>
</table>
@endsection
