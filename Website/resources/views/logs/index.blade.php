<@extends('main')

@section('title', __('messages.list_of_logs'))

@section('content')

<div class="pagetitle">
    <h1>{{ __('messages.list_of_logs') }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">{{ __('messages.list_of_logs') }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class='card-body'>
                    <table class="table datatable table-striped table-bordered table-hover mt-3">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        $('.datatable').DataTable({
            paging: true,        // Bật phân trang
            lengthChange: true,  // Cho phép thay đổi số lượng hàng trên mỗi trang
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]], // Tùy chọn "All" để hiển thị tất cả hàng
            searching: true,     // Bật tìm kiếm
            ordering: true,      // Bật sắp xếp
            dom: 'Bfrtip',       // Định dạng bố cục (Buttons, filter, table, pagination)
            info: false,         // Tắt thông báo "Showing ... entries"
            serverSide: false, // Đảm bảo server-side processing không được bật
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: 'Sao chép',
                    exportOptions: {
                        columns: ':not(:last-child)' // Loại bỏ cột cuối cùng
                    },
                    modifier: {
                        page: 'all' // Xuất tất cả dữ liệu
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: 'Xuất CSV',
                    exportOptions: {
                        columns: ':not(:last-child)' // Loại bỏ cột cuối cùng
                    },
                    modifier: {
                        page: 'all' // Xuất tất cả dữ liệu
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Xuất Excel',
                    exportOptions: {
                        columns: ':not(:last-child)' // Loại bỏ cột cuối cùng
                    },
                    modifier: {
                        page: 'all' // Xuất tất cả dữ liệu
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Xuất PDF',
                    exportOptions: {
                        columns: ':not(:last-child)' // Loại bỏ cột cuối cùng
                    },
                    modifier: {
                        page: 'all' // Xuất tất cả dữ liệu
                    }
                },
                {
                    extend: 'print',
                    text: 'In',
                    exportOptions: {
                        columns: ':not(:last-child)' // Loại bỏ cột cuối cùng
                    },
                    modifier: {
                        page: 'all' // Xuất tất cả dữ liệu
                    }
                }
            ]
        });
    });
</script>
@endsection
