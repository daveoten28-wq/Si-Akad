<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SiAkad-013</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom Style dengan Animasi Modern -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* --- ANIMASI KEYFRAMES --- */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(37, 99, 235, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
        }

        /* --- PENERAPAN ANIMASI PADA ELEMEN --- */
        .navbar-custom {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: fadeInDown 0.6s ease-out;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .card-profile {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: none;
            border-left: 5px solid #2563eb;
            border-radius: 12px;
            animation: fadeInUp 0.7s ease-out;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-profile:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
        }

        .profile-img {
            width: 85px;
            height: 85px;
            object-fit: cover;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: transform 0.4s ease;
        }

        .profile-img:hover {
            transform: scale(1.08) rotate(3deg);
        }

        .alert-animated {
            animation: fadeInUp 0.8s ease-out;
        }

        .stat-card {
            border: none;
            border-radius: 10px;
            animation: fadeInUp 0.9s ease-out;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
        }

        .badge-role {
            font-size: 0.85rem;
            padding: 6px 12px;
            border-radius: 20px;
            animation: pulseGlow 2s infinite;
        }

        .navbar-nav .nav-link {
            transition: color 0.2s ease, transform 0.2s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #38bdf8 !important;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <!-- NAVBAR TOP -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <i class="bi bi-mortarboard-fill text-primary"></i>
                <span>SiAkad-013</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="/siakad-013/dashboard">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    
                    @if(in_array(session('t013_role_name'), ['Admin', 'Dosen'], true))
                        <li class="nav-item">
                            <a class="nav-link" href="/siakad-013/matakuliah">
                                <i class="bi bi-book me-1"></i> Kelola Matakuliah
                            </a>
                        </li>
                    @endif

                    @if(session('t013_role_name') === 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="/siakad-013/users">
                                <i class="bi bi-people me-1"></i> Kelola Pengguna
                            </a>
                        </li>
                    @elseif(session('t013_role_name') === 'Dosen')
                        <li class="nav-item">
                            <a class="nav-link" href="/siakad-013/input-nilai">
                                <i class="bi bi-pencil-square me-1"></i> Input Nilai
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/siakad-013/khs">
                                <i class="bi bi-file-earmark-text me-1"></i> Lihat KHS
                            </a>
                        </li>
                    @endif
                </ul>

                <form action="/siakad-013/logout" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm px-3 rounded-pill" type="submit">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="container my-4">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- KARTU PROFIL PENGGUNA -->
        <div class="card card-profile shadow-sm p-3 mb-4">
            <div class="card-body d-flex flex-column flex-md-row align-items-center gap-4">
                <img src="{{ asset('images/dave.jpg.jpeg') }}" 
                     alt="Foto Profil Dave" 
                     class="profile-img rounded-circle">
                
                <div class="text-center text-md-start flex-grow-1">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-2 mb-1">
                        <!-- NAMA USER DINAMIS -->
                        <h3 class="fw-bold mb-0 text-dark">
                            Selamat Datang, {{ $displayName }}!
                        </h3>
                    </div>
                    <p class="text-muted mb-2">Sistem Informasi Akademik — Teknik Informatika</p>
                    
                    <!-- BADGE HAK AKSES DINAMIS -->
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                        <span class="text-secondary small fw-medium">Hak Akses:</span>
                        @if(session('t013_role_name') === 'Admin')
                            <span class="badge bg-danger badge-role"><i class="bi bi-shield-lock-fill me-1"></i> Administrator</span>
                        @elseif(session('t013_role_name') === 'Dosen')
                            <span class="badge bg-warning text-dark badge-role"><i class="bi bi-person-badge-fill me-1"></i> Dosen Pengampu</span>
                        @else
                            <span class="badge bg-primary badge-role"><i class="bi bi-person-fill me-1"></i> Mahasiswa Aktif</span>
                        @endif
                    </div>
                </div>

                <div class="border-start ps-4 d-none d-lg-block text-end">
                    <small class="text-muted d-block">Tahun Akademik</small>
                    <span class="fw-bold text-dark">2026/2027 Ganjil</span>
                </div>
            </div>
        </div>

        <!-- INFORMASI PEMBERITAHUAN -->
        <div class="alert alert-primary alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-3 alert-animated" role="alert">
            <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
            <div>
                <strong>Info Sistem:</strong> Anda berhasil masuk sebagai <strong>{{ session('t013_username') }}</strong>. Seluruh aktivitas akses Anda tercatat secara aman dalam sistem SiAkad-013.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <!-- QUICK STATS -->
        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block">Status Perkuliahan</span>
                            <h5 class="fw-bold mb-0 text-success"><i class="bi bi-check-circle-fill me-1"></i> Aktif</h5>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="bi bi-activity fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block">Modul Terintegrasi</span>
                            <h5 class="fw-bold mb-0 text-dark">5 Tabel Master</h5>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="bi bi-database-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block">Keamanan Akses</span>
                            <h5 class="fw-bold mb-0 text-dark">RBAC Middleware</h5>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="bi bi-shield-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>