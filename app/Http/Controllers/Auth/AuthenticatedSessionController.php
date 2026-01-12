<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $nomor_induk = $request->nomor_induk;
        $password = $request->password;

        $user = \App\Models\User::where('nomor_induk', $nomor_induk)->first();

        if ($user && Hash::check($password, $user->password)) {

            // Login user ke dalam session
            Auth::login($user);
            
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // 4. Jika gagal (user tidak ditemukan atau password salah)
        return back()->withErrors([
            'nomor_induk' => 'Nomor Induk atau Password salah.',
        ])->onlyInput('nomor_induk'); // Mengembalikan input nomor_induk agar tidak perlu ngetik ulang
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
