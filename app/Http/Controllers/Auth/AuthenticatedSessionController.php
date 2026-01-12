<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        // Ambil input
        $nomor_induk = $request->nomor_induk;
        $password = md5($request->password); // Menggunakan MD5 sesuai kode asli

        // Cek ke database manual karena Auth::attempt menggunakan bcrypt
        $user = \App\Models\User::where('nomor_induk', $nomor_induk)
                    ->where('password', $password)
                    ->first();

        if ($user) {
            // Login manual ke sistem Laravel
            auth()->login($user);
            
            $request->session()->regenerate();

            return redirect()->intended(route('index', absolute: false));
        }

        // Jika gagal
        return back()->withErrors([
            'nomor_induk' => 'Nomor Induk atau Password salah.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
