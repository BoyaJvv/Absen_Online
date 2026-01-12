<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Support\Facades\Auth;
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

        $user = \App\Models\User::where('nomor_induk', $this->nomor_induk)->first();

        // 1. Cek apakah user ada
        if (! $user) {
            $this->sendFailedLoginResponse();
        }

        // 2. Cek kecocokan password (Bcrypt atau MD5)
        $isBcrypt = \Illuminate\Support\Facades\Hash::check($this->password, $user->password);
        $isMd5 = ($user->password === md5($this->password));

        if ($isBcrypt || $isMd5) {
            // Upgrade otomatis ke Bcrypt jika user masih menggunakan MD5
            if ($isMd5) {
                $user->update([
                    'password' => \Illuminate\Support\Facades\Hash::make($this->password)
                ]);
            }

            // 3. Login sekali saja
            \Illuminate\Support\Facades\Auth::login($user, $this->boolean('remember'));
            
            RateLimiter::clear($this->throttleKey());
        } else {
            $this->sendFailedLoginResponse();
        }
    }

    /**
     * Helper untuk mengirim error agar kode tidak berulang (DRY)
     */
    protected function sendFailedLoginResponse(): void
    {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'nomor_induk' => __('auth.failed'),
        ]);
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