<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Nilai {{ $matakuliah->t013_kode_mk }} - SiAkad-013</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container py-4">
        <h2>Input Nilai Mahasiswa</h2>
        <p class="text-muted">{{ $matakuliah->t013_kode_mk }} - {{ $matakuliah->t013_nama_mk }} ({{ $matakuliah->t013_sks }} SKS)</p>
        <a href="/siakad-013/input-nilai" class="btn btn-secondary mb-3">Kembali ke Daftar Matakuliah</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr><th>NIM</th><th>Nama</th><th>Nilai Angka</th><th>Nilai Huruf</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @forelse($mahasiswas as $mahasiswa)
                            @php($nilai = $nilais->get($mahasiswa->t013_mahasiswa_id))
                            @php($oldInputForRow = (string) old('t013_mahasiswa_id') === (string) $mahasiswa->t013_mahasiswa_id)
                            @php($nilaiAngka = $oldInputForRow ? old('t013_nilai_angka') : ($nilai->t013_nilai_angka ?? ''))
                            @php($nilaiHuruf = $oldInputForRow ? old('t013_nilai_huruf') : ($nilai->t013_nilai_huruf ?? ''))
                            <tr>
                                <td>
                                    {{ $mahasiswa->t013_nim }}
                                    <form id="nilai-{{ $mahasiswa->t013_mahasiswa_id }}" action="/siakad-013/input-nilai/{{ $matakuliah->t013_mk_id }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="t013_mahasiswa_id" value="{{ $mahasiswa->t013_mahasiswa_id }}">
                                    </form>
                                </td>
                                <td>{{ $mahasiswa->t013_nama }}</td>
                                <td><input form="nilai-{{ $mahasiswa->t013_mahasiswa_id }}" type="number" name="t013_nilai_angka" class="form-control" min="0" max="100" step="0.01" value="{{ $nilaiAngka }}" required></td>
                                <td>
                                    <select form="nilai-{{ $mahasiswa->t013_mahasiswa_id }}" name="t013_nilai_huruf" class="form-select" required>
                                        <option value="">Pilih nilai</option>
                                        @foreach(['A', 'AB', 'B', 'BC', 'C', 'D', 'E'] as $huruf)
                                            <option value="{{ $huruf }}" @selected($nilaiHuruf === $huruf)>{{ $huruf }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><button form="nilai-{{ $mahasiswa->t013_mahasiswa_id }}" class="btn btn-success btn-sm" type="submit">Simpan</button></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Belum ada data mahasiswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
