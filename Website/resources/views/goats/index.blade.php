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
    <h1>Danh sách dê</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item">Dê</li>
            <li class="breadcrumb-item">Danh sách dê</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addGoatModal">
                        <i class="bi bi-clipboard-plus"></i>
                        <span class="ms-2">Thêm dê mới</span>
                    </button>
                </div>

                <div class='card-body'>
                    <table class="table datatable table-striped table-bordered table-hover mt-3">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Tuổi</th>
                                <th>Xuất xứ</th>
                                <th>Trang trại</th>
                                <th> Giống </th>
                                <th colspan="2">Thao tác</th>
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
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa mục này?');">
                                            <i class="ri-delete-bin-5-line"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Ngừng sự kiện lan tỏa khi nhấn vào nút Cập nhật -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#udpModal{{ $goat->goat_id }}" onclick="event.stopPropagation();">
                                        <i class="bi bi-pencil-fill"></i> Cập nhật
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

<!-- Add Goat Modal -->
<div class="modal fade" id="addGoatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('goats.add') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm dê mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card p-4 shadow-sm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="goat_name" class="form-control" placeholder="Tên dê" required>
                                @error('goat_name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <input type="number" name="goat_age" class="form-control" placeholder="Tuổi dê" required>
                                @error('goat_age')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <select name="origin" class="form-control" required>
                                    <option value="Select">Chọn xuất xứ</option>
                                    <option value="imported">Nhập khẩu</option>
                                    <option value="born_on_farm">Sinh tại trang trại</option>
                                </select>
                                @error('origin')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <select name="breed_id" class="form-control" required>
                                    <option value="">Chọn giống</option>
                                    @foreach($breeds as $breed)
                                    <option value="{{ $breed->breed_id }}">{{ $breed->breed_name_vie }}</option>
                                    @endforeach
                                </select>
                                @error('breed_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success">Thêm dê</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Goat Modal -->
@foreach($goats as $goat)
<div class="modal fade" id="udpModal{{ $goat->goat_id }}" tabindex="-1" aria-labelledby="udpModalLabel{{ $goat->goat_id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('goats.udp', ['goat_id' => $goat->goat_id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="udpModalLabel{{ $goat->goat_id }}">Cập nhật thông tin dê</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card p-4 shadow-sm">
                        <div class="mb-3">
                            <label for="goat_name{{ $goat->goat_id }}" class="form-label">Tên dê</label>
                            <input type="text" id="goat_name{{ $goat->goat_id }}" name="goat_name" value="{{ $goat->goat_name }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="goat_age{{ $goat->goat_id }}" class="form-label">Tuổi dê</label>
                            <input type="number" id="goat_age{{ $goat->goat_id }}" name="goat_age" value="{{ $goat->goat_age }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="origin{{ $goat->goat_id }}" class="form-label">Xuất xứ</label>
                            <select id="origin{{ $goat->goat_id }}" name="origin" class="form-control">
                                <option value="imported" {{ $goat->origin == 'imported' ? 'selected' : '' }}>Nhập khẩu</option>
                                <option value="born_on_farm" {{ $goat->origin == 'born_on_farm' ? 'selected' : '' }}>Sinh tại trang trại</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dropdown cho farm_name -->
                    <div class="mb-3">
                        <label for="farm_id{{ $goat->goat_id }}" class="form-label">Trang trại</label>
                        <select id="farm_id{{ $goat->goat_id }}" name="farm_id" class="form-control">
                        @foreach($farms as $farm)
                            <option value="{{ $farm->farm_id }}" {{ $goat->farm_id == $farm->farm_id ? 'selected' : '' }}>
                                {{ $farm->farm_name }}
                            </option>
                        @endforeach
                    </select>


                    </div>

                    <!-- Dropdown cho breed_id -->
                    <div class="mb-3">
                        <label for="breed_id{{ $goat->goat_id }}" class="form-label">Giống dê</label>
                        <select id="breed_id{{ $goat->goat_id }}" name="breed_id" class="form-control">
                            @foreach($breeds as $breed)
                                <option value="{{ $breed->breed_id }}" {{ $goat->breed_id == $breed->breed_id ? 'selected' : '' }}>{{ $breed->breed_name_vie }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </div>
            </form>
        </div>
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
