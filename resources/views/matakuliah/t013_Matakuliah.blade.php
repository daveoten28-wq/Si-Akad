<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Matakuliah - SiAkad-013</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .navbar-custom {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeInDown 0.6s ease-out;
        }

        .main-card {
            border: none;
            border-radius: 12px;
            animation: fadeInUp 0.7s ease-out;
        }

        .table hover tbody tr:hover {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>

    <!-- NAVBAR TOP -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <i class="bi bi-mortarboard-fill text-primary"></i>
                <span>SiAkad-013</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link" href="/siakad-013/dashboard">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="/siakad-013/matakuliah">
                            <i class="bi bi-book me-1"></i> Kelola Matakuliah
                        </a>
                    </li>
                    @if(session('t013_role_id') == 1)
                        <li class="nav-item">
                            <a class="nav-link" href="/siakad-013/users">
                                <i class="bi bi-people me-1"></i> Kelola Pengguna
                            </a>
                        </li>
                    @endif
                </ul>

                <form action="/siakad-013/logout" method="POST" class="d-flex align-items-center">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm px-3 rounded-pill" type="submit">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="container my-4">
        <div class="card main-card shadow-sm p-4 bg-white">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1"><i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Daftar Matakuliah</h3>
                    <p class="text-muted small mb-0">Kelola kurikulum dan daftar matakuliah SiAkad-013</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="/siakad-013/dashboard" class="btn btn-outline-secondary rounded-pill btn-sm px-3 d-flex align-items-center gap-1">
                        <i class="bi bi-arrow-left"></i> Dashboard
                    </a>
                    <a href="/siakad-013/matakuliah/create" class="btn btn-primary rounded-pill btn-sm px-3 d-flex align-items-center gap-1">
                        <i class="bi bi-plus-circle-fill"></i> Tambah Matakuliah
                    </a>
                </div>
            </div>

            <!-- SEARCH BAR -->
            <form action="/siakad-013/matakuliah" method="GET" class="mb-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari Kode atau Nama Matakuliah..." value="{{ request('search') }}">
                    <button class="btn btn-primary px-4" type="submit">Cari</button>
                </div>
            </form>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-dark">
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Kode MK</th>
                            <th>Nama Matakuliah</th>
                            <th class="text-center">SKS</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matakuliah as $index => $mk)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $mk->t013_kode_mk }}</span></td>
                                <td class="fw-bold text-dark">{{ $mk->t013_nama_mk }}</td>
                                <td class="text-center"><span class="badge bg-info text-dark">{{ $mk->t013_sks }} SKS</span></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="/siakad-013/matakuliah/{{ $mk->t013_id }}/edit" class="btn btn-warning btn-sm text-dark px-2">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form action="/siakad-013/matakuliah/{{ $mk->t013_id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus matakuliah ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-2">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Data matakuliah tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>