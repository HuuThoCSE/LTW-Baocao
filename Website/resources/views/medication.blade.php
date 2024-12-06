@extends('main')

@section('title')
Quản lý thuốc
@endsection

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="pagetitle">
    <h1>List of Medications</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Medication</li>
            <li class="breadcrumb-item">List Medication</li>
            </ol>
        </nav>
</div><!-- End Page Title --> 

<div class="pagetitle d-flex align-items-center justify-content-between">
    <!-- Nút thêm thuốc -->
    <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
        <i class="bi bi-plus-circle me-2"></i> Add Medication
    </button>
</div>


<hr class="my-4">

<!-- Bảng danh sách thuốc -->
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Medication Code</th>
                <th>Medication Name</th>
                <th colspan="2">Operations</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medications as $medication)
            <tr>
                <td class="text-center">{{ $medication->medication_id }}</td>
                <td class="text-center">{{ $medication->medication_code }}</td>
                <td class="text-center">{{ $medication->medication_name }}</td>
                <td class="text-center">
                    <form action="{{ route('medication.del', $medication->medication_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa thuốc này?');" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
                <td class="text-center">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#udpModal{{$medication->medication_id}}">
                        <i class="bi bi-pencil-square"></i> Update
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">There are no drugs on the list.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal thêm thuốc -->
<div class="modal fade" id="addMedicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('medication.add') }}">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"> Add New Medicine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="medication_code" class="form-label">Medication Code:</label>
                        <input type="text" name="medication_code" class="form-control" placeholder="Nhập mã thuốc" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="medication_name" class="form-label">Medication Name:</label>
                        <input type="text" name="medication_name" class="form-control" placeholder="Nhập tên thuốc" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Medicine</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal cập nhật thuốc -->
@foreach($medications as $medication)
<div class="modal fade" id="udpModal{{$medication->medication_id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('medication.put', ['medication_id' => $medication->medication_id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Update drug information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="medication_code" class="form-label">Medication Code:</label>
                        <input type="text" name="medication_code" class="form-control" value="{{ $medication->medication_code }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="medication_name" class="form-label">Medication Name:</label>
                        <input type="text" name="medication_name" class="form-control" value="{{ $medication->medication_name }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
