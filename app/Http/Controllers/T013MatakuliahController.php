<?php

namespace App\Http\Controllers;

use App\Models\T013Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class T013MatakuliahController extends Controller
{
    // Tampilkan daftar matakuliah dengan pencarian dan paginasi
    public function index(Request $request)
    {
        $search = $request->input('search');

        $matakuliahs = T013Matakuliah::when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('t013_nama_mk', 'like', "%{$search}%")
                    ->orWhere('t013_kode_mk', 'like', "%{$search}%");
            });
        })->paginate(10);

        return view('matakuliah.t013_index', compact('matakuliahs', 'search'));
    }

    // Form tambah matakuliah
    public function create()
    {
        return view('matakuliah.t013_create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            't013_kode_mk' => 'required|string|max:255|unique:t013_matakuliah,t013_kode_mk',
            't013_nama_mk' => 'required|string|max:255',
            't013_sks' => 'required|integer|min:1|max:6',
        ]);

        T013Matakuliah::create($validated);

        return redirect('/siakad-013/matakuliah')->with('success', 'Matakuliah berhasil ditambahkan!');
    }

    // Form edit matakuliah
    public function edit($id)
    {
        $matakuliah = T013Matakuliah::findOrFail($id);

        return view('matakuliah.t013_edit', compact('matakuliah'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            't013_kode_mk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('t013_matakuliah', 't013_kode_mk')->ignore($id, 't013_mk_id'),
            ],
            't013_nama_mk' => 'required|string|max:255',
            't013_sks' => 'required|integer|min:1|max:6',
        ]);

        $matakuliah = T013Matakuliah::findOrFail($id);
        $matakuliah->update($validated);

        return redirect('/siakad-013/matakuliah')->with('success', 'Matakuliah berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        $matakuliah = T013Matakuliah::findOrFail($id);
        $matakuliah->delete();

        return redirect('/siakad-013/matakuliah')->with('success', 'Matakuliah berhasil dihapus!');
    }
}
