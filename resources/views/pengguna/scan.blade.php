<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cek Tag | Nusabot</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

<div class="w-full max-w-md text-center px-6">

    {{-- Jam --}}
    <div class="text-2xl font-medium text-gray-800 mb-6">
        <span id="ct"></span>
    </div>

    {{-- Pesan absen --}}
    @if(!empty($pesan_absen))
        <div class="text-green-600 font-bold text-lg mb-2">
            {{ $pesan_absen }}
        </div>
    @endif

    {{-- Nama --}}
    @if(!empty($nama))
        <div class="text-gray-700 mb-6">
            {{ $nama }}
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('pengguna.scan') }}">
        @csrf

        <div class="flex items-center bg-white rounded-full shadow-md px-4 py-2">

            {{-- Avatar --}}
            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                <img src="{{ asset('storage/logo/logo-me.png') }}"
                     class="w-8 h-8"
                     alt="Logo">
            </div>

            {{-- Input --}}
            <input
                type="password"
                name="tag"
                placeholder="Scan Tag Anda"
                class="flex-1 outline-none text-gray-700 placeholder-gray-400"
                autofocus
                required
            >

            {{-- Button --}}
            <button type="submit"
                class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>

    {{-- License --}}
    <div class="mt-8 flex justify-center">
        <img src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" alt="CC">
    </div>
</div>

{{-- Clock --}}
<script>
    function display_ct() {
        const x = new Date();
        const days = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
        const text =
            days[x.getDay()] + ", " +
            x.getDate() + "/" +
            (x.getMonth()+1) + "/" +
            x.getFullYear() + " " +
            x.toLocaleTimeString('id-ID');

        document.getElementById('ct').innerHTML = text;
        setTimeout(display_ct, 1000);
    }
    display_ct();
</script>

</body>
</html>
