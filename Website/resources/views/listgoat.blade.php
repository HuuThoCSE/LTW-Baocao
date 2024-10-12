@extends('main')

@section('title')
Danh sách dê
@endsection

@section('content')
<h1>List of Goats</h1>
<table >
<ul>
    @foreach($listgoats as $goat)
    
        <li>{{$goat->goat_id}}-{{ $goat->goat_name }} - {{$goat->goat_age}} - Origin: {{ $goat->origin }}</li>
   
        
    @endforeach
</ul>
</table>
@endsection
