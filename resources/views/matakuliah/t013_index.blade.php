<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Matakuliah - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Daftar Matakuliah SiAkad-013</h2>
        <a href="/siakad-013/dashboard" class="btn btn-secondary btn-sm mb-3">Kembali ke Dashboard</a>
        <a href="/siakad-013/matakuliah/create" class="btn btn-primary btn-sm mb-3">Tambah Matakuliah</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <!-- Form Pencarian -->
        <form action="/siakad-013/matakuliah" method="GET" class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Cari Kode atau Nama Matakuliah..." value="{{ $search ?? '' }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </form>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Nama Matakuliah</th>
                            <th>SKS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matakuliahs as $index => $mk)
                        <tr>
                            <td>{{ $matakuliahs->firstItem() + $index }}</td>
                            <td>{{ $mk->t013_kode_mk }}</td>
                            <td>{{ $mk->t013_nama_mk }}</td>
                            <td>{{ $mk->t013_sks }}</td>
                            <td>
                                <a href="/siakad-013/matakuliah/{{ $mk->t013_mk_id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/siakad-013/matakuliah/{{ $mk->t013_mk_id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data matakuliah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Paginasi -->
                <div class="d-flex justify-content-center">
                    {{ $matakuliahs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>