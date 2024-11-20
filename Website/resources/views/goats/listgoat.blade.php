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
                <th>Id</th>
                <th>Name</th>
                <th>Age</th>
                <th>Origin</th>
                <th>Location</th>
                <th>Breed</th>
                <th colspan="2">Operation</th>
            </tr>
        </thead>
     
        @foreach($goats as $goat)
            <tr align='center' onclick="window.location='{{ route('goats.show', ['id' => $goat->goat_id]) }}'" style="cursor:pointer;">
                <td>{{ $goat->goat_id }}</td>
                <td>{{ $goat->goat_name }}</td>
                <td>{{ $goat->goat_age }}</td>
                <td>{{ $goat->origin }}</td>
                <td>{{ $goat->farm_name }}</td>
                <td>{{ $goat->breed_name }}</td>
                
                 <!-- Display farm name -->
                <td align='center'>
                        <form action="{{ route('goats.del', $goat->goat_id) }}" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger d-flex align-items-center">
                                Delete
                                <div class="icon" style="margin-left: 10px;">
                                    <i class="ri-delete-bin-5-line"></i>
                                </div>
                            </button>
                        </form>
                </td>
                <td align='center'>
                    <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#udpModal{{ $goat->goat_id }}" onclick="event.stopPropagation();">
                        Update
                        <div class="icon" style="margin-left: 10px;">
                            <i class="bi bi-arrow-clockwise"></i>
                        </div>
                    </button>
                </td>

            </tr>
        @endforeach
       
    </table>
</div>

<!-- Nút "New Goat" -->
<button id="newGoatBtn" class="btn btn-primary d-flex align-items-center" onclick="showAddGoatForm(); return true">
    New Goat
    <i class="ri-add-circle-fill ms-2"></i> <!-- Biểu tượng nằm bên phải -->
</button>

<!-- Form "Add Goat" (ban đầu ẩn) -->
<div id="addGoatForm" style="display: none; margin-top: 20px;">
    <h2>Add New Goat</h2>
    <form action="{{ route('goats.add') }}" method="POST">
        @csrf
        <table class="table table-border">
            <tr>
                <td>
                    <input type="text" name="goat_name" class="form-control" placeholder="Goat Name">
                    @error('goat_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <input type="text" name="goat_age" class="form-control" placeholder="Goat Age">
                    @error('goat_age')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
                <td>
                    <select name="origin" class="form-control">
                        <option value="Select">Select origin</option>
                        <option value="imported">Imported</option>
                        <option value="born_on_farm">Born on farm</option>
                    </select>
                    @error('origin')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>

                <td>
                    <select name="farm_id" class="form-control">
                        <option value="Area">Select Area</option>
                        <option value="1">Vinh Long Goat Farm</option>
                        <option value="2">Tien Giang Goat Farm</option>
                        <option value="3">Ben Tre Goat Farm</option>
                    </select>
                    @error('farm_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>

                <td>
                    <select name="breed_id" class="form-control">
                        <option value="Breed">Select Breed</option>
                        <option value="1">Saanen</option>
                        <option value="2">Boer</option>
                        <option value="3">Nubian</option>
                        <option value="4">Alpine</option>
                        <option value="5">Anglo-Nubian</option>
                        <option value="6">LaMancha</option>
                        <option value="7">Bách Thảo</option>
                        <option value="8">Cỏ</option>
                    </select>
                    @error('breed_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
        </table>

        <!-- Nút "Add Goat" -->
        <button type="submit" class="btn btn-primary d-flex align-items-center">
            Add Goat
            <i class="bi bi-clipboard-plus ms-2"></i> <!-- Biểu tượng nằm bên phải -->
        </button>
    </form>
</div>

<!-- JavaScript -->
<script>
    function showAddGoatForm() {
        console.log('showAddGoatForm has been called'); 
        // Ẩn nút "New Goat"
        document.getElementById('newGoatBtn').style.display = 'none';
        // Hiện form "Add Goat"
        document.getElementById('addGoatForm').style.display = 'block';
    }
</script>


<!-- Madol Update -->
@foreach($goats as $goat)
    <div class="modal fade" id="udpModal{{ $goat->goat_id }}" tabindex="-1">
        <div class="modal-dialog modal-small">
            <div class="modal-content">
                <form id="updateForm{{ $goat->goat_id }}" method="POST" action="{{ route('goats.udp', ['goat_id' => $goat->goat_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Update Goat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="goat_name{{ $goat->goat_id }}" class="col-form-label">Name:</label>
                            <input type="text" id="goat_name{{ $goat->goat_id }}" name="goat_name" value="{{ $goat->goat_name }}" class="form-control" placeholder="Goat Name">
                        </div>
                        <div class="form-group">
                            <label for="goat_age{{ $goat->goat_id }}" class="col-form-label">Age:</label>
                            <input type="text" id="goat_age{{ $goat->goat_id }}" name="goat_age" value="{{ $goat->goat_age }}" class="form-control" placeholder="Goat Age">
                        </div>
                        <div class="form-group">
                            <label for="origin{{ $goat->goat_id }}" class="col-form-label">Origin:</label>
                            <select id="origin{{ $goat->goat_id }}" name="origin" class="form-control">
                                <option value="imported" {{ $goat->origin == 'imported' ? 'selected' : '' }}>Imported</option>
                                <option value="born_on_farm" {{ $goat->origin == 'born_on_farm' ? 'selected' : '' }}>Born on farm</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="farm_id{{ $goat->goat_id }}" class="col-form-label">Location:</label>
                            <select id="farm_id{{ $goat->goat_id }}" name="farm_id" class="form-control">
                                <option value="1" {{ $goat->farm_id == 1 ? 'selected' : '' }}>Vinh Long Goat Farm</option>
                                <option value="2" {{ $goat->farm_id == 2 ? 'selected' : '' }}>Tien Giang Goat Farm</option>
                                <option value="3" {{ $goat->farm_id == 3 ? 'selected' : '' }}>Ben Tre Goat Farm</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="breed_id{{ $goat->goat_id }}" class="col-form-label">Breed:</label>
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<!-- End Basic Modal-->

<script>
    function fillUpdateForm(id, name, age, origin, farm_id, breed_id) {
        document.getElementById(`goat_name${id}`).value = name;
        document.getElementById(`goat_age${id}`).value = age;
        document.getElementById(`origin${id}`).value = origin;
        document.getElementById(`farm_id${id}`).value = farm_id;
        document.getElementById(`breed_id${id}`).value = breed_id;
    }
</script>

@endsection
