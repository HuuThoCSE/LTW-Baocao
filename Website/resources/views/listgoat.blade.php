@extends('main')

@section('title')
Danh sách dê
@endsection

@section('content')
<h1>List of Goats</h1>
<ul>
    @foreach($listgoats as $goat)
        <li>{{ $goat->goat_name }} - Origin: {{ $goat->origin }}</li>
    @endforeach
</ul>
@endsection
