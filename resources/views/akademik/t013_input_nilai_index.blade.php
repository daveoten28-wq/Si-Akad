<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Nilai - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-4">
        <h2>Input Nilai Mahasiswa</h2>
        <a href="/siakad-013/dashboard" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Pilih Matakuliah</h5>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead><tr><th>Kode</th><th>Matakuliah</th><th>SKS</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($matakuliahs as $matakuliah)
                                <tr>
                                    <td>{{ $matakuliah->t013_kode_mk }}</td>
                                    <td>{{ $matakuliah->t013_nama_mk }}</td>
                                    <td>{{ $matakuliah->t013_sks }}</td>
                                    <td><a class="btn btn-primary btn-sm" href="/siakad-013/input-nilai/{{ $matakuliah->t013_mk_id }}">Input Nilai</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">Belum ada matakuliah.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
