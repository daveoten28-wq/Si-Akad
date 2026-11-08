<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KHS - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-4">
        <h2>Kartu Hasil Studi (KHS)</h2>
        <a href="/siakad-013/dashboard" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <section class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $mahasiswa->t013_nama }}</h5>
                <div>NIM: {{ $mahasiswa->t013_nim }}</div>
                <div>Program Studi: {{ $mahasiswa->t013_prodi }}</div>
            </div>
        </section>
        <section class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>No.</th><th>Kode MK</th><th>Matakuliah</th><th>SKS</th><th>Nilai Angka</th><th>Nilai Huruf</th></tr></thead>
                    <tbody>
                        @forelse($nilais as $nilai)
                            @if($nilai->mataKuliah)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $nilai->mataKuliah->t013_kode_mk }}</td>
                                    <td>{{ $nilai->mataKuliah->t013_nama_mk }}</td>
                                    <td>{{ $nilai->mataKuliah->t013_sks }}</td>
                                    <td>{{ number_format($nilai->t013_nilai_angka, 2) }}</td>
                                    <td>{{ $nilai->t013_nilai_huruf }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr><td colspan="6" class="text-center">Belum ada nilai yang tersedia.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot><tr><th colspan="3" class="text-end">Total SKS</th><th>{{ $totalSks }}</th><th colspan="2"></th></tr></tfoot>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
