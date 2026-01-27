<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HakAksesMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // belum login
        if (!$user) {
            abort(403);
        }

        $hakAkses = optional($user->jabatanStatus)->hak_akses;

        // selain 0 dan 1 → user biasa
        if (!in_array((int) $hakAkses, [0, 1])) {
            // boleh lanjut, tapi akses terbatas
            // route yang kena middleware ini hanya utk admin
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
