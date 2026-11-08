<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SiAkad-013</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: #2563eb;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 15px auto;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            padding: 10px;
            font-weight: 600;
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>
<body>

    <div class="card login-card p-4 my-3">
        <div class="card-body text-center">
            <div class="brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1">SiAkad-013</h4>
            <p class="text-muted small mb-4">Sistem Informasi Akademik Teknik Informatika</p>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-start small" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger text-start small" role="alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="/siakad-013/login" method="POST" class="text-start">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                        <input type="text" name="t013_username" class="form-control bg-light border-start-0" placeholder="Masukkan Username / NIM" value="{{ old('t013_username') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" name="t013_password" class="form-control bg-light border-start-0" placeholder="Masukkan Password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-primary-custom text-white w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Ke Sistem
                </button>
            </form>

            <div class="mt-4 pt-3 border-top text-muted small">
                Dave Austen Susilo &bull; NIM: 25.K1.0013
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>