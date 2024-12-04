@extends('main')

@section('title', 'Barn Details')

@section('contents')
<div class="container mt-4">
    <h1 class="text-center mb-4">Barn Details</h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>{{ $barn->barn_name }}</h5>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $barn->barn_id }}</p>
            <p><strong>Location:</strong> {{ $barn->location ?? 'Not provided' }}</p>
            <p><strong>Description:</strong> {{ $barn->description ?? 'No description available' }}</p>
            <p><strong>Area ID:</strong> {{ $barn->area_id }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('listbarn') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
