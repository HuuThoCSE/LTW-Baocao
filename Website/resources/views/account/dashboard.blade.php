@extends('main')

@section('title', 'Manage Accounts')

@section('account_style')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 18px;
        text-align: left;
    }

    table, th, td {
        border: 1px solid #dddddd;
    }

    th, td {
        padding: 12px;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr {
        cursor: pointer;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .pagetitle {
        margin-bottom: 20px;
    }

    .breadcrumb a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="pagetitle">
    <h1>Account Management</h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Account Management</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th colspan="2">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->user_email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <form action="{{ route('account.del', $user->user_id) }}" method="POST" style="display:inline;">
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
                                        <button class="btn btn-success btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#udpModal{{$user->user_id}}">
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="ms-2">Update</span>
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

@endsection
