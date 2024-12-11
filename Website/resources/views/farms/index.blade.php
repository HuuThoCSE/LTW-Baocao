@extends('main')

@section('title', 'Dashboard')

@section('content')
    <div class="pagetitle">
        <h1>Bảng điều khiển</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang trại</a></li>
                <li class="breadcrumb-item active">Danh sách Trang trại</li>
            </ol>
        </nav>
    </div>

    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success mt-3 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Hiển thị thông báo lỗi -->
    @if ($errors->any())
        <div class="alert alert-danger mt-3 rounded shadow-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Các style tùy chỉnh cho nút -->
    <style>
        /* Hiệu ứng khi di chuột vào nút */
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

                    <!-- Header của thẻ card chứa nút thêm trang trại -->
                    <div class="card-header">
                        <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addFarmModal">
                            <i class="bi bi-clipboard-plus"></i>
                            <span class="ms-2">Thêm Trang trại</span>
                        </button>
                    </div>

                    <!-- Thân của thẻ card chứa bảng danh sách trang trại -->
                    <div class='card-body'>
                        <table class="table datatable table-striped table-bordered table-hover mt-3">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Tên Trang trại</th>
                                    <th class="text-center">Vị trí</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($farms as $farm)
                                <tr class="text-center">
                                    <td>{{ $farm->farm_id }}</td>
                                    <td>{{ $farm->farm_name }}</td>
                                    <td>{{ $farm->location }}</td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <!-- Nút Xóa -->
                                        <form action="{{ route('farms.del', $farm->farm_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?');">
                                                <i class="ri-delete-bin-5-line"></i>
                                                <span class="ms-1">Xóa</span>
                                            </button>
                                        </form>

                                        <!-- Nút Cập nhật -->
                                        <button class="btn btn-success btn-sm d-flex align-items-center ms-2" data-bs-toggle="modal" data-bs-target="#udpModal{{$farm->farm_id}}">
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="ms-1">Cập nhật</span>
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

        <!-- Modal Thêm Trang trại -->
        <div class="modal fade" id="addFarmModal" tabindex="-1" aria-labelledby="addFarmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addFarmForm">
                        @csrf
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addFarmModalLabel">Thêm Trang trại Mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Thông báo lỗi chung -->
                            <div id="error-alert" class="alert alert-danger d-none"></div>

                            <!-- Các trường nhập liệu -->
                            <div class="form-group mb-3">
                                <label for="farm_name" class="form-label">Tên Trang trại:</label>
                                <input type="text" name="farm_name" class="form-control" placeholder="Nhập tên trang trại" id="farm_name">
                                <span class="text-danger error-farm_name"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label for="location" class="form-label">Vị trí:</label>
                                <textarea name="location" class="form-control" placeholder="Nhập vị trí" id="location"></textarea>
                                <span class="text-danger error-location"></span>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-check-label" for="inp_email">Email:</label>
                                <input type="email" name="inp_email" id="inp_email" class="form-control" placeholder="Nhập email của chủ trang trại">
                            </div>

                            <div class="form-check mb-3">
                                <!-- Giá trị ẩn để gửi "off" khi checkbox không được chọn -->
                                <input type="hidden" name="chb_old_owner" value="off">
                                <input type="checkbox" name="chb_old_owner" id="chb_old_owner" class="form-check-input" value="on">
                                <label class="form-check-label" for="chb_old_owner">Chủ sở hữu hiện tại</label>
                            </div>

                            <div class="form-mb-3" id="select_old_owner">
                                <label for="sel_owner_id" class="form-label">Chủ sở hữu:</label>
                                <select name="sel_owner_id" id="sel_owner_id" class="form-select">
                                    <option value="">Chọn Chủ sở hữu</option>
                                    <!-- Các tùy chọn sẽ được nạp qua AJAX -->
                                </select>
                                <span class="text-danger error-sel_owner_id"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm Trang trại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Cập nhật Trang trại -->
        @foreach($farms as $farm)
            <div class="modal fade" id="udpModal{{$farm->farm_id}}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded">
                        <form method="POST" action="{{ route('farms.udp', ['farm_id' => $farm->farm_id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Cập nhật Trang trại</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="farm_name" class="form-label">Tên Trang trại:</label>
                                    <input type="text" name="farm_name" class="form-control" value="{{ $farm->farm_name }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="location" class="form-label">Vị trí:</label>
                                    <select name="location" class="form-control">
                                        <option value="Province" {{ $farm->location == 'Province' ? 'selected' : '' }}>Chọn Tỉnh</option>
                                        <option value="Vinh Long Province" {{ $farm->location == 'Vinh Long Province' ? 'selected' : '' }}>Tỉnh Vĩnh Long</option>
                                        <option value="Tien Giang Province" {{ $farm->location == 'Tien Giang Province' ? 'selected' : '' }}>Tỉnh Tiền Giang</option>
                                        <option value="Ben Tre Province" {{ $farm->location == 'Ben Tre Province' ? 'selected' : '' }}>Tỉnh Bến Tre</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="owner_id" class="form-label">Chủ sở hữu:</label>
                                    <select name="udp_sel_owner_id" id="udp_sel_owner_id" class="form-select">
                                        <option value="">Chọn Chủ sở hữu</option>
                                        <!-- Các tùy chọn sẽ được nạp qua AJAX -->
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Lưu Thay đổi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    <!-- Bao gồm các thư viện cần thiết -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CSS của DataTables -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- CSS của DataTables Buttons -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.0/css/buttons.dataTables.min.css">

    <!-- JS của DataTables -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- JS của DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.0/js/dataTables.buttons.min.js"></script>

    <!-- JSZip cho việc xuất Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- pdfmake cho việc xuất PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Các script bổ sung cho DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.0/js/buttons.print.min.js"></script>

    <!-- Khởi tạo DataTables với các nút chức năng -->
    <script>
        $(document).ready(function () {
            // Định nghĩa exportOptions một lần để sử dụng cho tất cả các nút
            var commonExportOptions = {
                columns: ':not(:last-child)' // Loại bỏ cột cuối cùng (thường là cột thao tác)
            };

            $('.datatable').DataTable({
                "paging": true,        // Bật phân trang
                searching: true,    // Tắt tìm kiếm của DataTables
                "ordering": true,      // Bật sắp xếp
                dom: 'Bfrtip',         // Định dạng bố cục (Buttons, filter, table, pagination)
                info: false,         // Tắt thông báo "Showing ... entries"
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Sao chép',
                        exportOptions: commonExportOptions
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'Xuất CSV',
                        exportOptions: commonExportOptions
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Xuất Excel',
                        exportOptions: commonExportOptions
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Xuất PDF',
                        exportOptions: commonExportOptions
                    },
                    {
                        extend: 'print',
                        text: 'In',
                        exportOptions: commonExportOptions
                    }
                ]
            });
        });
    </script>

    <!-- Các script cho chức năng thêm và cập nhật trang trại -->
    <script>
        $(document).ready(function () {
            // Khi nhấn nút thêm (không cần vì modal tự động mở)
            // $('#btn-add').on('click', function () {
            //     // Không cần mã này vì modal đã tự động mở khi nhấn nút
            // });

            // Ẩn phần chọn chủ sở hữu cũ ban đầu
            $('#select_old_owner').hide();

            // Khi thay đổi trạng thái checkbox "Chủ sở hữu hiện tại"
            $('#chb_old_owner').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#select_old_owner').show(); // Hiển thị phần chọn chủ sở hữu
                } else {
                    $('#select_old_owner').hide(); // Ẩn phần chọn chủ sở hữu
                }
            });

            // Xử lý sự kiện gửi form thêm trang trại
            $('#addFarmForm').on('submit', function (e) {
                e.preventDefault(); // Ngăn trang web tải lại

                // Lấy dữ liệu từ form
                let formData = $(this).serialize();

                // Gửi dữ liệu qua AJAX
                $.ajax({
                    url: '{{ route('farms.add') }}',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        // Nếu thành công, hiển thị thông báo và đóng modal
                        $('#error-alert').addClass('d-none'); // Ẩn thông báo lỗi chung
                        $('.text-danger').text(''); // Xóa thông báo lỗi từng trường
                        alert(response.message); // Hiển thị thông báo thành công
                        $('#addFarmModal').modal('hide'); // Đóng modal
                        location.reload(); // Tải lại trang để cập nhật danh sách trang trại
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON); // In lỗi ra console để kiểm tra

                        // Nếu có lỗi, hiển thị trong modal
                        let errors = xhr.responseJSON.errors;

                        // Hiển thị lỗi chung
                        $('#error-alert').removeClass('d-none').text('Có lỗi xảy ra. Vui lòng kiểm tra các trường bên dưới.');

                        // Hiển thị lỗi cụ thể từng trường
                        $('.text-danger').text(''); // Reset các thông báo lỗi cũ
                        if (errors) {
                            $.each(errors, function (key, value) {
                                $('.error-' + key).text(value[0]);
                            });
                        }
                    }
                });
            });

            // Hàm để nạp danh sách chủ sở hữu qua AJAX khi mở modal thêm trang trại
            $('#addFarmModal').on('show.bs.modal', function () {
                $.ajax({
                    url: '{{ route('api.getOwners') }}',
                    method: 'GET',
                    success: function (data) {
                        // Xóa các tùy chọn cũ trong select
                        $('#sel_owner_id').empty();

                        // Thêm tùy chọn mặc định
                        $('#sel_owner_id').append('<option value="">Chọn Chủ sở hữu</option>');

                        // Kiểm tra và thêm dữ liệu
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
                        console.error('Lỗi:', error);
                    },
                });
            });

            // Bạn có thể thêm các hàm tương tự để nạp dữ liệu cho modal cập nhật nếu cần
        });
    </script>

@endsection
