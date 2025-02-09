<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        @include('layouts.sideNav')
        <div class="content-wrapper" style="margin-left: 250px; width: calc(100% - 250px);">
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">
                            @if(Auth::user()->hak_akses == 'admin')
                                Daftar Semua Users
                            @else
                                Daftar Member
                            @endif
                        </h5>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus"></i> Tambah User
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>No. Telp</th>
                                        <th>Alamat</th>
                                        @if(Auth::user()->hak_akses == 'admin')
                                            <th>Role</th>
                                        @endif
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ((Auth::user()->hak_akses == 'admin' ? $allmember : $member) as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->no_telp }}</td>
                                        <td>{{ $user->alamat }}</td>
                                        @if(Auth::user()->hak_akses == 'admin')
                                            <td>
                                                <span class="badge bg-{{ $user->hak_akses == 'admin' ? 'danger' : ($user->hak_akses == 'kasir' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($user->hak_akses) }}
                                                </span>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-warning" onclick="editUser({{ $user->id }})" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if(Auth::user()->hak_akses == 'admin')
                                                <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telp</label>
                            <input type="text" class="form-control" name="no_telp" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" required></textarea>
                        </div>
                        @if (Auth::user()->hak_akses == 'admin')
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="member">Member</option>
                                <option value="kasir">Kasir</option>
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();
        });
    </script>
</body>

</html>
