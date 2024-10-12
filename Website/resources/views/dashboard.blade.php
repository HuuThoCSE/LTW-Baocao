@extends('main')

@section('title')
Bảng điều khiển
@endsection

@section('content')
<form action="">
    <h1>Con bò</h1>
    <label for="">ID: </label>
    <input type="text" value="1">
</form>
@endsection

@extends('main')

@section('title')
Quản sức khỏe
@endsection

@section('content')
<h1>List of Goats</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Age</th>
    </tr>
    <tr>
        <td>1</td>
        <td>25</td>
    </tr>
</table>
@endsection