<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class T013CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $hasSession = session()->has('logged_in') || session()->has('t013_role_name');

        if (! $hasSession) {
            return redirect('/siakad-013/login')->withErrors(['msg' => 'Silakan login terlebih dahulu!']);
        }

        $userRole = strtolower((string) (session('t013_role_name') ?? ''));
        $allowedRoles = array_map(fn ($role) => strtolower((string) $role), $roles);

        if (in_array($userRole, $allowedRoles, true)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
