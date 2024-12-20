@extends('main')

@section('title', 'List of BreedModel')

@section('content')

<div class="pagetitle">
<h1>{{ __('messages.breed_list') }}</h1>
<nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">{{ __('messages.breed') }}</li>
    </ol>
</nav>
</div><!-- End Page Title -->

<section class="section">
<div class="row">
    <div class="col-lg-12">
    <div class="card">
        <!-- Table with stripped rows -->
        <div class="card-header">
            <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#btnAdd">
                <i class="bi bi-clipboard-plus"></i>
                <span class="ms-2">{{ __('messages.add_breed') }}</span>
            </button>
        </div>

        <div class='card-body'>
            <table class="table datatable table-striped table-bordered table-hover mt-3">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>English Name</th>
                        <th>Vietnamese Name</th>
                        <th>Description</th>
                        <th colspan="2">Operation</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($breeds as $breed)
                    <tr>
                        <td>{{ $breed->breed_id }}</td>
                        <td>{{ $breed->breed_name_eng }}</td>
                        <td>{{ $breed->breed_name_vie }}</td>
                        <td>{{ $breed->description }}</td>
                        <td>
                            <form action="{{ route('breeds.del', $breed->breed_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');"
                                        class="btn btn-danger btn-sm d-flex align-items-center">
                                    <i class="ri-delete-bin-5-line"></i>
                                    <span class="ms-2">Delete</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#updateBreedModal"
                                data-id="{{$breed->breed_id}}"
                                data-breed_name_eng="{{$breed->breed_name_eng}}"
                                data-breed_name_vie="{{$breed->breed_name_vie}}"
                                data-description="{{$breed->description}}">
                                <i class="bi bi-pencil-square"></i>
                                Update
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
</section>

<!-- Modal Add Breed -->
<div class="modal fade" id="btnAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('breeds.add') }}">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Breed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="breed_name_eng" class="form-label">English Name:</label>
                        <input type="text" name="breed_name_eng" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="breed_name_vie" class="form-label">Vietnamese Name:</label>
                        <input type="text" name="breed_name_vie" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Breed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update Breed -->
<div class="modal fade" id="updateBreedModal" tabindex="-1" aria-labelledby="updateBreedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateBreedModalLabel">Update Breed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateBreedForm" action="{{ route('breeds.udp', ':id') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="breed_name_eng">English Name</label>
                        <input type="text" id="breed_name_eng" name="breed_name_eng" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="breed_name_vie">Vietnamese Name</label>
                        <input type="text" id="breed_name_vie" name="breed_name_vie" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Lắng nghe sự kiện khi modal được kích hoạt
    var updateBreedModal = document.getElementById('updateBreedModal');

    updateBreedModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Nút "Update" được nhấn
        var breedId = button.getAttribute('data-id'); // Lấy ID giống breed_id
        var breedNameEng = button.getAttribute('data-breed_name_eng');
        var breedNameVie = button.getAttribute('data-breed_name_vie');
        var description = button.getAttribute('data-description');

        // Kiểm tra dữ liệu đã được lấy đúng chưa
        console.log(breedId, breedNameEng, breedNameVie, description);

        // Điền dữ liệu vào modal
        var breedNameEngInput = updateBreedModal.querySelector('#breed_name_eng');
        var breedNameVieInput = updateBreedModal.querySelector('#breed_name_vie');
        var descriptionInput = updateBreedModal.querySelector('#description');

        breedNameEngInput.value = breedNameEng;
        breedNameVieInput.value = breedNameVie;
        descriptionInput.value = description;

        // Cập nhật URL của form với breed_id
        var formAction = "/breeds/" + breedId; // Xây dựng URL trực tiếp trong JavaScript
        console.log("Form Action: ", formAction); // Kiểm tra URL của form

        // Cập nhật action của form
        var updateBreedForm = updateBreedModal.querySelector('#updateBreedForm');
        updateBreedForm.setAttribute('action', formAction);
    });
});
</script>

@endsection
