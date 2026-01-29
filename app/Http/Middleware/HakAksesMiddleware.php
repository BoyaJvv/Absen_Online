<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HakAksesMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // belum login
        if (!$user) {
            return response()->view('errors.access_denied', [
                'message' => 'Anda harus login terlebih dahulu',
                'action' => 'login'
            ], 403);
        }

        // Dapatkan hak akses dari jabatan status user
        $jabatanStatus = $user->jabatanStatus;
        
        if (!$jabatanStatus) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return response()->view('errors.access_denied', [
                'message' => 'User tidak memiliki jabatan status yang terkait',
                'action' => 'logout',
                'debug' => [
                    'user_id' => $user->nomor_induk,
                    'jabatan_status_id' => $user->jabatan_status,
                ]
            ], 403);
        }
        
        $hakAkses = $jabatanStatus->hakAkses;
        
        if (!$hakAkses) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return response()->view('errors.access_denied', [
                'message' => 'Jabatan status tidak memiliki hak akses yang terkait',
                'action' => 'logout',
                'debug' => [
                    'jabatan_status_id' => $jabatanStatus->id,
                    'hak_akses_id' => $jabatanStatus->hak_akses,
                ]
            ], 403);
        }

        // Dapatkan nama hak akses dari relasi (kolom 'hak')
        $userHakAkses = $hakAkses->hak;

        // Periksa apakah user punya salah satu role yang diizinkan
        if (!in_array($userHakAkses, $roles)) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return response()->view('errors.access_denied', [
                'message' => "Akses ditolak. Anda memiliki role '{$userHakAkses}' tetapi membutuhkan: " . implode(', ', $roles),
                'action' => 'logout',
                'debug' => [
                    'user_role' => $userHakAkses,
                    'required_roles' => $roles,
                ]
            ], 403);
        }

        return $next($request);
    }
}
