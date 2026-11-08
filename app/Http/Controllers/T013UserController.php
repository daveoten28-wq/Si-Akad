<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class T013UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = DB::table('t013_users')
            ->leftJoin('t013_roles', 't013_users.t013_role_id', '=', 't013_roles.t013_role_id')
            ->select('t013_users.*', 't013_roles.t013_role_name')
            ->when($search, function ($query, $search) {
                return $query->where('t013_users.t013_username', 'like', "%{$search}%");
            })
            ->orderBy('t013_users.t013_user_id')
            ->paginate(10);

        return view('t013_users_index', compact('users', 'search'));
    }

    public function create()
    {
        $roles = DB::table('t013_roles')->get();

        return view('t013_users_create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:t013_users,t013_username'],
            'password' => ['required', 'string', 'min:8'],
            'role_id' => ['required', 'integer', 'exists:t013_roles,t013_role_id'],
        ]);
        $this->assertMahasiswaProfileAvailable(null, $validated['username'], (int) $validated['role_id']);

        $userId = DB::table('t013_users')->insertGetId([
            't013_username' => $validated['username'],
            't013_password' => Hash::make($validated['password']),
            't013_role_id' => $validated['role_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ], 't013_user_id');

        $this->linkMahasiswaAccount($userId, $validated['username'], (int) $validated['role_id']);

        return redirect('/siakad-013/users')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = DB::table('t013_users')->where('t013_user_id', $id)->firstOrFail();
        $roles = DB::table('t013_roles')->get();

        return view('t013_users_edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        DB::table('t013_users')->where('t013_user_id', $id)->firstOrFail();

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('t013_users', 't013_username')->ignore($id, 't013_user_id'),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'role_id' => ['required', 'integer', 'exists:t013_roles,t013_role_id'],
        ]);
        $this->assertMahasiswaProfileAvailable((int) $id, $validated['username'], (int) $validated['role_id']);

        $data = [
            't013_username' => $validated['username'],
            't013_role_id' => $validated['role_id'],
            'updated_at' => now(),
        ];

        if (! empty($validated['password'])) {
            $data['t013_password'] = Hash::make($validated['password']);
        }

        DB::table('t013_users')->where('t013_user_id', $id)->update($data);
        $this->linkMahasiswaAccount((int) $id, $validated['username'], (int) $validated['role_id']);

        if ((int) $id === (int) session('t013_user_id')) {
            $roleName = DB::table('t013_roles')
                ->where('t013_role_id', $validated['role_id'])
                ->value('t013_role_name');
            session([
                't013_username' => $validated['username'],
                't013_role_id' => (int) $validated['role_id'],
                't013_role_name' => $roleName,
            ]);

            return redirect('/siakad-013/dashboard')->with('success', 'Akun Anda berhasil diperbarui.');
        }

        return redirect('/siakad-013/users')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('t013_users')->where('t013_user_id', $id)->firstOrFail();

        if ((int) $id === (int) session('t013_user_id')) {
            return redirect('/siakad-013/users')
                ->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        DB::table('t013_users')->where('t013_user_id', $id)->delete();

        return redirect('/siakad-013/users')->with('success', 'User berhasil dihapus!');
    }

    private function linkMahasiswaAccount(int $userId, string $username, int $roleId): void
    {
        $roleName = DB::table('t013_roles')
            ->where('t013_role_id', $roleId)
            ->value('t013_role_name');

        if (strcasecmp((string) $roleName, 'Mahasiswa') !== 0) {
            return;
        }

        DB::table('t013_mahasiswas')
            ->where('t013_user_id', $userId)
            ->update(['t013_nim' => $username, 'updated_at' => now()]);

        DB::table('t013_mahasiswas')
            ->where('t013_nim', $username)
            ->whereNull('t013_user_id')
            ->update(['t013_user_id' => $userId, 'updated_at' => now()]);
    }

    private function assertMahasiswaProfileAvailable(?int $userId, string $username, int $roleId): void
    {
        $roleName = DB::table('t013_roles')
            ->where('t013_role_id', $roleId)
            ->value('t013_role_name');

        if (strcasecmp((string) $roleName, 'Mahasiswa') !== 0) {
            return;
        }

        $linkedProfile = $userId !== null
            ? DB::table('t013_mahasiswas')->where('t013_user_id', $userId)->first()
            : null;
        $profile = DB::table('t013_mahasiswas')->where('t013_nim', $username)->first();

        if (! $linkedProfile && (! $profile || $profile->t013_user_id !== null)) {
            throw ValidationException::withMessages([
                'username' => 'Untuk role Mahasiswa, masukkan NIM yang sudah terdaftar dan belum terhubung ke akun lain.',
            ]);
        }

        if ($linkedProfile && $profile && (int) $profile->t013_mahasiswa_id !== (int) $linkedProfile->t013_mahasiswa_id) {
            throw ValidationException::withMessages([
                'username' => 'NIM tersebut sudah terhubung ke akun mahasiswa lain.',
            ]);
        }
    }
}
