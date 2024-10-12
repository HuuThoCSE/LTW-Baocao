@extends('main')

@section('title')
Quản lý dê
@endsection

@section('content')
<h1>List of Goats</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Age</th>
            <th>Goat breeds</th>
            <th>Gender</th>
            <th>Weighed</th>
            <th>Health Conditions</th>
            <th>Intended Use</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>25</td>
            <td>Saanen</td>
            <td>male</td>
            <td>70kg</td>
            <td>Good</td>
            <td>Eat</td>
            <td>...</td>
        </tr>
        <tr>
            <td>2</td>
            <td>15</td>
            <td> Nubian</td>
            <td>female</td>
            <td>80kg</td>
            <td>Fairly</td>
            <td>milk</td>
            <td>Requires special care, Need to isolate</td>
        </tr>
        <tr>
            <td>3</td>
            <td>12</td>
            <td>Boer</td>
            <td>male</td>
            <td>75kg</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
@endsection