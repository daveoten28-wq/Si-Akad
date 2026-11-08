<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 col-md-6">
        <h3>Tambah User Baru</h3>
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form action="/siakad-013/users" method="POST">
            @csrf
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" minlength="8" required>
            </div>
            <div class="mb-3">
                <label>Role/Level</label>
                <select name="role_id" class="form-control" required>
                    @foreach($roles as $r)
                        <option value="{{ $r->t013_role_id }}" @selected(old('role_id') == $r->t013_role_id)>{{ $r->t013_role_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="/siakad-013/users" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>