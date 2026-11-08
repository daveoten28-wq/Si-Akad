<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class T013AuthController extends Controller
{
    public function showLogin()
    {
        return view('t013_login');
    }

    public function showLoginForm()
    {
        return view('t013_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            't013_username' => ['required', 'string'],
            't013_password' => ['required', 'string'],
        ]);

        $user = DB::table('t013_users')
            ->join('t013_roles', 't013_users.t013_role_id', '=', 't013_roles.t013_role_id')
            ->where('t013_users.t013_username', $credentials['t013_username'])
            ->select('t013_users.*', 't013_roles.t013_role_name')
            ->first();

        if (! $user) {
            return back()->with('error', 'Username atau password tidak valid.');
        }

        $isLegacyPassword = hash_equals($user->t013_password, $credentials['t013_password']);
        $storedPasswordInfo = password_get_info($user->t013_password);
        $hasRecognizedHash = $storedPasswordInfo['algoName'] !== 'unknown';
        $passwordIsValid = $isLegacyPassword || (
            $hasRecognizedHash && Hash::check($credentials['t013_password'], $user->t013_password)
        );

        if (! $passwordIsValid) {
            return back()->with('error', 'Username atau password tidak valid.');
        }

        if ($isLegacyPassword || Hash::needsRehash($user->t013_password)) {
            DB::table('t013_users')
                ->where('t013_user_id', $user->t013_user_id)
                ->update(['t013_password' => Hash::make($credentials['t013_password'])]);
        }

        $request->session()->regenerate();
        session([
            't013_user_id' => $user->t013_user_id,
            't013_username' => $user->t013_username,
            't013_role_id' => (int) $user->t013_role_id,
            't013_role_name' => $user->t013_role_name,
            'logged_in' => true,
        ]);

        return redirect('/siakad-013/dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/siakad-013/login');
    }
}
