<?php

namespace App\Http\Controllers;

use App\Models\T013Mahasiswa;
use App\Models\T013MataKuliah;
use App\Models\T013Nilai;
use Illuminate\Http\Request;

class T013AkademikController extends Controller
{
    public function index()
    {
        $mahasiswa = T013Mahasiswa::all();
        $nilais = T013Nilai::with(['mahasiswa', 'mataKuliah'])->get();
        $matakuliah = T013MataKuliah::all();

        return response()->json([
            'status' => 'success',
            'nim' => '25.K1.0013',
            'nama' => 'Dave Austen Susilo',
            'data_mahasiswa' => $mahasiswa,
            'data_matakuliah' => $matakuliah,
            'data_nilai' => $nilais,
        ]);
    }

    public function gradeCourses()
    {
        $matakuliahs = T013MataKuliah::orderBy('t013_kode_mk')->get();

        return view('akademik.t013_input_nilai_index', compact('matakuliahs'));
    }

    public function gradeStudents($matakuliah)
    {
        $matakuliah = T013MataKuliah::findOrFail($matakuliah);
        $mahasiswas = T013Mahasiswa::orderBy('t013_nim')->get();
        $nilais = T013Nilai::where('t013_mk_id', $matakuliah->t013_mk_id)
            ->get()
            ->keyBy('t013_mahasiswa_id');

        if ($mahasiswas->isEmpty()) {
            return view('akademik.t013_input_nilai', compact('matakuliah', 'mahasiswas', 'nilais'))
                ->with('warning', 'Belum ada data mahasiswa yang terdaftar.');
        }

        return view('akademik.t013_input_nilai', compact('matakuliah', 'mahasiswas', 'nilais'));
    }

    public function storeGrade(Request $request, $matakuliah)
    {
        $matakuliah = T013MataKuliah::findOrFail($matakuliah);
        $validated = $request->validate([
            't013_mahasiswa_id' => ['required', 'integer', 'exists:t013_mahasiswas,t013_mahasiswa_id'],
            't013_nilai_angka' => ['required', 'numeric', 'min:0', 'max:100'],
            't013_nilai_huruf' => ['required', 'in:A,AB,B,BC,C,D,E'],
        ]);

        T013Nilai::updateOrCreate(
            [
                't013_mahasiswa_id' => $validated['t013_mahasiswa_id'],
                't013_mk_id' => $matakuliah->t013_mk_id,
            ],
            [
                't013_nilai_angka' => $validated['t013_nilai_angka'],
                't013_nilai_huruf' => $validated['t013_nilai_huruf'],
            ]
        );

        return redirect("/siakad-013/input-nilai/{$matakuliah->t013_mk_id}")
            ->with('success', 'Nilai mahasiswa berhasil disimpan.');
    }

    public function khs()
    {
        $mahasiswa = T013Mahasiswa::where('t013_user_id', session('t013_user_id'))->first();

        if (! $mahasiswa) {
            $mahasiswa = T013Mahasiswa::where('t013_nim', session('t013_username'))->first();
        }

        abort_unless($mahasiswa, 404, 'Data mahasiswa untuk akun ini tidak ditemukan.');

        $nilais = T013Nilai::with('mataKuliah')
            ->where('t013_mahasiswa_id', $mahasiswa->t013_mahasiswa_id)
            ->get();
        $totalSks = $nilais->sum(function ($nilai) {
            return $nilai->mataKuliah->t013_sks ?? 0;
        });

        return view('akademik.t013_khs', compact('mahasiswa', 'nilais', 'totalSks'));
    }
}
