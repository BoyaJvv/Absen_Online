<x-guest-layout>

<x-auth-session-status class="mb-4" :status="session(key: 'aktif')" />

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Nomor Induk -->
    <div class="input-group mb-3">
        <x-input-label for="email" :value="__('Email')" />
        <input id="nomor_induk"class="block mt-1 w-full" type="text" name="nomor_induk"  placeholder="Nomor Induk" value="{{ old('nomor_induk') }}" required autofocus>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
        </div>
    </div>
    <x-input-error :messages="$errors->get('nomor_induk')" class="mt-2" />

    <!-- Password -->
    <div class="input-group mb-3">
        <x-input-label for="password" :value="__('Password')" />
        <input id="password"class="block mt-1 w-full" type="password" name="password" placeholder="Password" required>
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
    </div>
    <x-input-error :messages="$errors->get('password')" class="mt-2" />

      <!-- Remember Me -->
        <!-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div> -->

    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </div>
    </div>
</form>
</x-guest-layout>
