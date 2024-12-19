@extends('main')

@section('title', 'Manage Accounts')

@section('content')
<div class="pagetitle">
    <h1>Account Management</h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Account Management</li>
        </ol>
    </nav>
</div>
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

                <div class="card-header">
                        <button class="btn btn-primary d-flex align-items-center ms-auto" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                            <i class="bi bi-clipboard-plus"></i>
                            <span class="ms-2">Add Account</span>
                        </button>
                </div>

                <div class="card-body">
                    <table class="table datatable table-striped table-bordered table-hover mt-3">
                        <thead class="text-center">
                            <tr >
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">{{ __('messages.status') }}</th>
                                <th class="text-center">Created At</th>
                                <th >Operations</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->user_email }}</td>
                                    <td>{{ $user->role_id}}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td class="d-flex justify-content-center align-items-center" >
                                        <form action="{{ route('account.del', $user->user_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');"
                                                    class="btn btn-danger btn-sm d-flex align-items-center">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                    <span class="ms-2">Delete</span>
                                            </button>
                                        </form>

                                        <button class="btn btn-success btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#udpModal{{$user->user_id}}">
                                            <i class="bi bi-pencil-square"></i>
                                            <span >Update</span>
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
<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded">
            <form action="{{ route('account.add') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="user_name" class="form-label">Account Name:</label>
                        <input type="text" name="user_name" class="form-control" placeholder="Enter account name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="user_email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_password" class="form-label">Password:</label>
                        <input type="password" name="user_password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select name="role_id" class="form-control" required>
                        <option value="">Select Role</option>
                        @foreach($farm_roles as $role)
                            <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
                "searching": true,     // Bật tìm kiếm
                "ordering": true,      // Bật sắp xếp
                dom: 'Bfrtip',         // Định dạng bố cục (Buttons, filter, table, pagination)
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
@endsection
