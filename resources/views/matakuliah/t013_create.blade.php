<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($matakuliah) ? 'Edit' : 'Tambah' }} Matakuliah - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-body">
                <h3>{{ isset($matakuliah) ? 'Edit' : 'Tambah' }} Matakuliah</h3>
                @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <form action="{{ isset($matakuliah) ? '/siakad-013/matakuliah/'.$matakuliah->t013_mk_id : '/siakad-013/matakuliah' }}" method="POST">
                    @csrf
                    @if(isset($matakuliah))
                        @method('PUT')
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Kode MK</label>
                        <input type="text" name="t013_kode_mk" class="form-control" value="{{ old('t013_kode_mk', $matakuliah->t013_kode_mk ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" name="t013_nama_mk" class="form-control" value="{{ old('t013_nama_mk', $matakuliah->t013_nama_mk ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" name="t013_sks" class="form-control" min="1" max="6" value="{{ old('t013_sks', $matakuliah->t013_sks ?? '') }}" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="/siakad-013/matakuliah" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>