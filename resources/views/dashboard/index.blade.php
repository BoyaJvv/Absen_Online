@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $totalTepat   = array_sum($tepatWaktu);
    $totalTelat   = array_sum($terlambat);
    $totalHadir   = $totalTepat + $totalTelat;
    $persenTepat  = $totalHadir > 0 ? round($totalTepat / $totalHadir * 100) : 0;
    $namaDepan    = explode(' ', trim(auth()->user()->nama ?? auth()->user()->name ?? 'Pengguna'))[0];
    $bulanIni     = \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y');
@endphp

<div class="space-y-6">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-indigo-100 text-sm font-medium mb-1" id="greeting">Selamat datang,</p>
                <h2 class="text-2xl md:text-3xl font-extrabold text-white m-0">{{ $namaDepan }} 👋</h2>
                <p class="text-indigo-100 text-sm mt-2 mb-0">
                    Ringkasan kehadiran <strong class="text-white">{{ $lokasiCabang }}</strong> · {{ $bulanIni }}
                </p>
            </div>

            {{-- FILTER CABANG (ADMIN & PIMPINAN) --}}
            @if (in_array($hakAkses, [0, 1]))
                <form method="GET" class="md:w-72">
                    <label class="text-[11px] uppercase tracking-wider font-bold text-indigo-100 mb-1 block">Filter Cabang</label>
                    <select name="cabangGedung" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Cabang</option>
                        @foreach ($cabangGedungList as $cabang)
                            <option value="{{ $cabang->id }}" {{ $cabangGedungId == $cabang->id ? 'selected' : '' }}>
                                {{ $cabang->lokasi }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="stat-card" style="color:#4f46e5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-label">Total Absen Masuk</div>
                    <div class="stat-value mt-2">{{ number_format($totalHadir) }}</div>
                </div>
                <div class="stat-icon" style="background:#eef2ff;color:#4f46e5"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="text-xs text-slate-500 mt-3">Bulan {{ $bulanIni }}</div>
        </div>

        <div class="stat-card" style="color:#16a34a">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-label">Tepat Waktu</div>
                    <div class="stat-value mt-2">{{ number_format($totalTepat) }}</div>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a"><i class="bi bi-check-circle-fill"></i></div>
            </div>
            <div class="text-xs text-slate-500 mt-3">Absen sebelum / pukul 08:00</div>
        </div>

        <div class="stat-card" style="color:#e11d48">
            <div class="flex items-center justify-between">
                <div>
                    <div class="stat-label">Terlambat</div>
                    <div class="stat-value mt-2">{{ number_format($totalTelat) }}</div>
                </div>
                <div class="stat-icon" style="background:#ffe4e6;color:#e11d48"><i class="bi bi-alarm-fill"></i></div>
            </div>
            <div class="text-xs text-slate-500 mt-3">Absen setelah pukul 08:00</div>
        </div>

        <div class="stat-card" style="color:#d97706">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="stat-label">Tingkat Ketepatan</div>
                    <div class="stat-value mt-2">{{ $persenTepat }}<span style="font-size:1.1rem">%</span></div>
                </div>
                <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="mt-3" style="height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                <div style="width:{{ $persenTepat }}%;height:100%;background:linear-gradient(90deg,#f59e0b,#fbbf24);border-radius:99px"></div>
            </div>
        </div>
    </div>

    {{-- CHART --}}
    <div class="card">
        <div class="card-body" style="padding:1.5rem">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div>
                    <h3 class="text-lg font-bold m-0">Grafik Absen Masuk Harian</h3>
                    <p class="text-sm text-slate-500 m-0">{{ $lokasiCabang }} · {{ $bulanIni }}</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-semibold text-slate-600">
                    <span class="inline-flex items-center gap-1.5"><i style="width:10px;height:10px;border-radius:3px;background:#22c55e;display:inline-block"></i> Tepat Waktu</span>
                    <span class="inline-flex items-center gap-1.5"><i style="width:10px;height:10px;border-radius:3px;background:#f43f5e;display:inline-block"></i> Terlambat</span>
                </div>
            </div>
            <div style="position:relative;height:340px">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const tepatWaktu = @json($tepatWaktu);
    const terlambat = @json($terlambat);

    // sapaan sesuai jam
    (function () {
        const h = new Date().getHours();
        const s = h < 11 ? 'Selamat pagi,' : h < 15 ? 'Selamat siang,' : h < 18 ? 'Selamat sore,' : 'Selamat malam,';
        document.getElementById('greeting').textContent = s;
    })();

    Chart.defaults.font.family = "'Plus Jakarta Sans', system-ui, sans-serif";
    Chart.defaults.color = '#64748b';

    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const gradGreen = ctx.createLinearGradient(0, 0, 0, 340);
    gradGreen.addColorStop(0, '#4ade80'); gradGreen.addColorStop(1, '#16a34a');
    const gradRed = ctx.createLinearGradient(0, 0, 0, 340);
    gradRed.addColorStop(0, '#fb7185'); gradRed.addColorStop(1, '#e11d48');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Tepat Waktu', data: tepatWaktu, backgroundColor: gradGreen, borderRadius: 6, borderSkipped: false, maxBarThickness: 22 },
                { label: 'Terlambat', data: terlambat, backgroundColor: gradRed, borderRadius: 6, borderSkipped: false, maxBarThickness: 22 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            scales: {
                x: { grid: { display: false }, title: { display: true, text: 'Tanggal', color: '#94a3b8' } },
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, grid: { color: '#eef1f6', drawBorder: false }, border: { display: false } }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a', padding: 12, cornerRadius: 10, titleFont: { weight: '700' },
                    callbacks: { title: items => 'Tanggal ' + items[0].label }
                }
            }
        }
    });
</script>
@endsection
