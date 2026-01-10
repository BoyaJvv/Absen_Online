<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk input login.
     */
    public function rules(): array
    {
        return [
            'nomor_induk' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Proses autentikasi kustom menggunakan MD5 dan nomor_induk.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Cari user berdasarkan nomor_induk dan password MD5
        $user = \App\Models\User::where('nomor_induk', $this->nomor_induk)
                    ->where('password', md5($this->password))
                    ->first();

        if (! $user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nomor_induk' => __('auth.failed'),
            ]);
        }

        // Login manual ke Laravel
        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Memastikan request login tidak terkena pembatasan (Throttling).
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            // Diubah dari 'email' menjadi 'nomor_induk' agar pesan error muncul di input yang benar
            'nomor_induk' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Membuat kunci unik untuk pembatasan login (Throttle Key).
     */
    public function throttleKey(): string
    {
        // Diubah dari email ke nomor_induk agar kunci pembatasan konsisten
        return Str::transliterate(Str::lower($this->string('nomor_induk')).'|'.$this->ip());
    }
}