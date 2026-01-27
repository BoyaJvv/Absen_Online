@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Dashboard Absensi</h4>

    {{-- FILTER CABANG (HANYA ADMIN & PIMPINAN) --}}
    @if (in_array($hakAkses, [0, 1]))
        <form method="GET" class="mb-4">
            <select name="cabangGedung"
                class="form-select w-25"
                onchange="this.form.submit()">

                <option value="">-- Semua Cabang --</option>

                @foreach ($cabangGedungList as $cabang)
                    <option value="{{ $cabang->id }}"
                        {{ $cabangGedungId == $cabang->id ? 'selected' : '' }}>
                        {{ $cabang->lokasi }}
                    </option>
                @endforeach
            </select>
        </form>
    @endif

    <div class="card">
        <div class="card-body">
            <canvas id="attendanceChart" height="110"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = @json($labels);
    const tepatWaktu = @json($tepatWaktu);
    const terlambat = @json($terlambat);
    const lokasiCabang = "{{ $lokasiCabang }}";

    new Chart(document.getElementById('attendanceChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tepat Waktu',
                    data: tepatWaktu,
                    backgroundColor: 'rgba(34,197,94,0.7)'
                },
                {
                    label: 'Terlambat',
                    data: terlambat,
                    backgroundColor: 'rgba(239,68,68,0.7)'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Absen Masuk - ' + lokasiCabang
                }
            }
        }
    });
</script>
@endsection
