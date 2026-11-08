<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Kelola Pengguna</h2>
        <a href="/siakad-013/dashboard" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <a href="/siakad-013/users/create" class="btn btn-primary mb-3">+ Tambah User</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="/siakad-013/users" class="mb-3 d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari username..." value="{{ $search }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role/Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $u->t013_user_id }}</td>
                    <td>{{ $u->t013_username }}</td>
                    <td><span class="badge bg-info text-dark">{{ $u->t013_role_name }}</span></td>
                    <td>
                        <a href="/siakad-013/users/{{ $u->t013_user_id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/siakad-013/users/{{ $u->t013_user_id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Tidak ada pengguna ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</body>
</html>