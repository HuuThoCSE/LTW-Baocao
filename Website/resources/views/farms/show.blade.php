@extends('main')

@section('content')
    <h1>{{ $farm->farm_name }}</h1>
    <p><strong>Location:</strong> {{ $farm->location }}</p>
    <p><strong>Owner ID:</strong> {{ $farm->owner_id }}</p>
    <p><strong>Created At:</strong> {{ $farm->created_at }}</p>
    <p><strong>Updated At:</strong> {{ $farm->updated_at }}</p>
    <a href="{{ route('farms.index') }}">Quay lại danh sách</a>
@endsection
