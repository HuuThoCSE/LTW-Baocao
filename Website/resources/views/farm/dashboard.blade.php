@extends('main-admin')

@section('title', 'Dashboard')

<!-- Success and Error messages -->
@if (session('success'))
    <div class="alert alert-success mt-3 rounded shadow-sm">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mt-3 rounded shadow-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Farm</a></li>
            <li class="breadcrumb-item active">List Farm</li>
        </ol>
    </nav>
</div>

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

<section class="section">
<div class="row">
    <div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addBarnModal">
                <i class="bi bi-clipboard-plus"></i>
                <span class="ms-2">Add Farm</span>
            </button>
        </div>



        <div class='card-body'>
            <table class="table datatable table-striped table-bordered table-hover mt-3">
                <thead class="text-center"> 
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th colspan="2">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach($farms as $farm)
            <tr class="text-center">
                <td>{{ $farm->farm_id }}</td>
                <td>{{ $farm->farm_name }}</td>
                <td>{{ $farm->location }}</td>
                <td>
                    <!-- Delete Button -->
                    <form action="{{ route('listfarm.del', $farm->farm_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="ri-delete-bin-5-line"></i>
                            <span class="ms-1">Delete</span>
                        </button>
                    </form>
                </td>
                <td>
                    <!-- Update Button -->
                    <button class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#udpModal{{$farm->farm_id}}">
                        <i class="bi bi-pencil-square"></i>
                        <span class="ms-1">Update</span>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Adding Farm -->
<div class="modal fade" id="addFarmModal" tabindex="-1" aria-labelledby="addFarmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addFarmForm">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addFarmModalLabel">Add New Farm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- General error message -->
                    <div id="error-alert" class="alert alert-danger d-none"></div>

                    <!-- Form fields -->
                    <div class="form-group mb-3">
                        <label for="farm_name" class="form-label">Farm Name:</label>
                        <input type="text" name="farm_name" class="form-control" placeholder="Enter farm name" id="farm_name">
                        <span class="text-danger error-farm_name"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="location" class="form-label">Location:</label>
                        <textarea name="location" class="form-control" placeholder="Enter location" id="location"></textarea>
                        <span class="text-danger error-location"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-check-label" for="inp_email">Email:</label>
                        <input type="email" name="inp_email" id="inp_email" class="form-control" placeholder="Enter email of farm owner">
                    </div>

                    <div class="form-check mb-3">
                        <input type="hidden" name="chb_old_owner" value="off">
                        <input type="checkbox" name="chb_old_owner" id="chb_old_owner" class="form-check-input" value="on">
                        <label class="form-check-label" for="chb_old_owner">Existing Owner</label>
                    </div>

                    <div class="form-mb-3" id="select_old_owner">
                        <label for="sel_owner_id" class="form-label">Owner:</label>
                        <select name="sel_owner_id" id="sel_owner_id" class="form-select">
                            <option value="">Select Owner</option>
                        </select>
                        <span class="text-danger error-sel_owner_id"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Farm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Updating Farm -->
@foreach($farms as $farm)
<div class="modal fade" id="udpModal{{$farm->farm_id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded">
            <form method="POST" action="{{ route('listfarm.udp', ['farm_id' => $farm->farm_id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Update Farm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="farm_name" class="form-label">Farm Name:</label>
                        <input type="text" name="farm_name" class="form-control" value="{{ $farm->farm_name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="location" class="form-label">Location:</label>
                        <select name="location" class="form-control">
                            <option value="Province" {{ $farm->location == 'Province' ? 'selected' : '' }}>Select Province</option>
                            <option value="Vinh Long Province" {{ $farm->location == 'Vinh Long Province' ? 'selected' : '' }}>Vinh Long Province</option>
                            <option value="Tien Giang Province" {{ $farm->location == 'Tien Giang Province' ? 'selected' : '' }}>Tien Giang Province</option>
                            <option value="Ben Tre Province" {{ $farm->location == 'Ben Tre Province' ? 'selected' : '' }}>Ben Tre Province</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="owner_id" class="form-label">Owner:</label>
                        <select name="udp_sel_owner_id" id="udp_sel_owner_id" class="form-select">
                            <option value="">Select Owner</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#btn-add').on('click', function () {
            $.ajax({
                url: '{{ route('api.getOwners') }}',
                method: 'GET',
                success: function (data) {
                    // Xóa các option cũ trong select
                    $('#sel_owner_id').empty();

                    // Thêm option mặc định
                    $('#sel_owner_id').append('<option value="">Select Owner</option>');

                    // Kiểm tra và thêm dữ liệu
                    console.log(data); // Kiểm tra dữ liệu trả về
                    if (Array.isArray(data)) {
                        data.forEach(function (owner) {
                            $('#sel_owner_id').append(
                                `<option value="${owner.user_id}">${owner.user_id} - ${owner.user_name}</option>`
                            );
                        });
                    } else {
                        console.error('API không trả về mảng:', data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                },
            });
        });

        $('#select_old_owner').hide(); // Ẩn phần tử ban đầu

        $('#chb_old_owner').on('change', function () {
            if ($(this).is(':checked')) {
                $('#select_old_owner').show(); // Hiển thị
            } else {
                $('#select_old_owner').hide(); // Ẩn
            }
        });

        $('#addFarmForm').on('submit', function (e) {
            e.preventDefault(); // Ngăn reload trang

            // Lấy dữ liệu form
            let formData = $(this).serialize();

            // Gửi dữ liệu qua AJAX
            $.ajax({
                url: '{{ route('listfarm.add') }}',
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Nếu thành công, hiển thị thông báo và đóng modal
                    $('#error-alert').addClass('d-none'); // Ẩn lỗi
                    $('.text-danger').text(''); // Xóa lỗi cụ thể
                    alert(response.message); // Hiển thị thông báo thành công
                    $('#addFarmModal').modal('hide'); // Đóng modal
                    location.reload(); // Reload lại trang để cập nhật danh sách farm
                },
                error: function (xhr) {
                    console.log(xhr.responseJSON); // LogModel lỗi để kiểm tra

                    // Nếu có lỗi, hiển thị trong modal
                    let errors = xhr.responseJSON.errors;

                    // Hiển thị lỗi chung
                    $('#error-alert').removeClass('d-none').text('Có lỗi xảy ra. Vui lòng kiểm tra các trường bên dưới.');

                    // Hiển thị lỗi cụ thể từng trường
                    $('.text-danger').text(''); // Reset lỗi cũ
                    if (errors) {
                        $.each(errors, function (key, value) {
                            $('.error-' + key).text(value[0]);
                        });
                    }
                }
            });
        });
    });
</script>

@endsection
