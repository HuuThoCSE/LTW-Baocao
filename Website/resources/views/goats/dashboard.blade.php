@extends('main')

@section('title')
Danh sách dê
@endsection

@section('content')

<style>
/* Add hover effect for buttons */
.btn:hover {
    transform: scale(1.1);
    transition: transform 0.3s ease-in-out;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-success:hover {
    background-color: #218838;
}

</style>
<div class="pagetitle">
    <h1>List of Goats</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">Goats</li>
            <li class="breadcrumb-item">List of Goat</li>
            </ol>
        </nav>
</div><!-- End Page Title --> 
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                <div class="card-header">
                    <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addBarnModal">
                        <i class="bi bi-clipboard-plus"></i>
                        <span class="ms-2">{{ __('messages.add_goat') }}</span>
                    </button>
                </div>

                    <div class='card-body'>
                            <table class="table datatable table-striped table-bordered table-hover mt-3">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Origin</th>
                                        <th>Farm</th>
                                        <th>Breed</th>
                                        <th colspan="2">Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($goats as $goat)
                                    <tr class="text-center" onclick="window.location='{{ route('goats.show', ['id' => $goat->goat_id]) }}'" style="cursor:pointer;">
                                        <td>{{ $goat->goat_id }}</td>
                                        <td>{{ $goat->goat_name }}</td>
                                        <td>{{ $goat->goat_age }}</td>
                                        <td>{{ $goat->origin }}</td>
                                        <td>{{ $goat->farm_name }}</td>
                                        <td>{{ $goat->breed_name_vie }}</td>
                                        <td>
                                            <form action="{{ route('goats.del', $goat->goat_id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="ri-delete-bin-5-line"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#udpModal{{ $goat->goat_id }}" onclick="event.stopPropagation();">
                                                <i class="bi bi-pencil-fill"></i> Update
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    <!-- Add GoatModel Modal -->
    <div class="modal fade" id="addGoatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('goats.add') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Goat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="card p-4 shadow-sm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" name="goat_name" class="form-control" placeholder="Goat Name" required>
                                    @error('goat_name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="number" name="goat_age" class="form-control" placeholder="Goat Age" required>
                                    @error('goat_age')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <select name="origin" class="form-control" required>
                                        <option value="Select">Select Origin</option>
                                        <option value="imported">Imported</option>
                                        <option value="born_on_farm">Born on Farm</option>
                                    </select>
                                    @error('origin')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            <div class="col-md-6 mb-3">
                                <select name="breed_id" class="form-control" required>
                                    <option value="">Select Breed</option>
                                    @foreach($breeds as $breed)
                                        <option value="{{ $breed->breed_id }}">{{ $breed->breed_id }} - {{ $breed->breed_name_vie }}</option>
                                    @endforeach
                                </select>
                                @error('breed_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Goat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Update GoatModel Modal -->
@foreach($goats as $goat)
<div class="modal fade" id="udpModal{{ $goat->goat_id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('goats.udp', ['goat_id' => $goat->goat_id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Update Goat Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card p-4 shadow-sm">
                        <div class="mb-3">
                            <label for="goat_name{{ $goat->goat_id }}" class="form-label">Goat Name</label>
                            <input type="text" id="goat_name{{ $goat->goat_id }}" name="goat_name" value="{{ $goat->goat_name }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="goat_age{{ $goat->goat_id }}" class="form-label">Goat Age</label>
                            <input type="number" id="goat_age{{ $goat->goat_id }}" name="goat_age" value="{{ $goat->goat_age }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="origin{{ $goat->goat_id }}" class="form-label">Origin</label>
                            <select id="origin{{ $goat->goat_id }}" name="origin" class="form-control">
                                <option value="imported" {{ $goat->origin == 'imported' ? 'selected' : '' }}>Imported</option>
                                <option value="born_on_farm" {{ $goat->origin == 'born_on_farm' ? 'selected' : '' }}>Born on Farm</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="breed_id{{ $goat->goat_id }}" class="form-label">Breed</label>
                            <select id="breed_id{{ $goat->goat_id }}" name="breed_id" class="form-control">
                                <option value="1" {{ $goat->breed_id == 1 ? 'selected' : '' }}>Saanen</option>
                                <option value="2" {{ $goat->breed_id == 2 ? 'selected' : '' }}>Boer</option>
                                <option value="3" {{ $goat->breed_id == 3 ? 'selected' : '' }}>Nubian</option>
                                <option value="4" {{ $goat->breed_id == 4 ? 'selected' : '' }}>Alpine</option>
                                <option value="5" {{ $goat->breed_id == 5 ? 'selected' : '' }}>Anglo-Nubian</option>
                                <option value="6" {{ $goat->breed_id == 6 ? 'selected' : '' }}>LaMancha</option>
                                <option value="7" {{ $goat->breed_id == 7 ? 'selected' : '' }}>Bách Thảo</option>
                            <option value="8" {{ $goat->breed_id == 8 ? 'selected' : '' }}>Cỏ</option>
                        </select>
                    </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <script>
        function showAddGoatForm() {
            document.getElementById('newGoatBtn').style.display = 'none';
            document.getElementById('addGoatForm').style.display = 'block';
        }
    </script>

@endsection
