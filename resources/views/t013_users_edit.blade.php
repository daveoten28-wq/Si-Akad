<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Pengguna - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container mt-4 col-md-6">
        <h3>Edit Pengguna</h3>
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form action="/siakad-013/users/{{ $user->t013_user_id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="username" class="form-label">Username / NIM</label>
                <input id="username" type="text" name="username" class="form-control" value="{{ old('username', $user->t013_username) }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password baru (kosongkan jika tidak diubah)</label>
                <input id="password" type="password" name="password" class="form-control" minlength="8">
            </div>
            <div class="mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select id="role_id" name="role_id" class="form-select" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->t013_role_id }}" @selected(old('role_id', $user->t013_role_id) == $role->t013_role_id)>{{ $role->t013_role_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="/siakad-013/users" class="btn btn-secondary">Batal</a>
        </form>
    </main>
</body>
</html>
