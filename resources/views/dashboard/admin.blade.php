@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-6">Welcome {{ Auth::user()->name }}!</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-orange-100 p-4 rounded-lg text-center">
            <div class="text-3xl font-bold">{{ $totalProducts }}</div>
            <p>Total Products</p>
        </div>
        <div class="bg-orange-100 p-4 rounded-lg text-center">
            <div class="text-3xl font-bold">{{ $barangRusak }}</div>
            <p>Barang Rusak</p>
        </div>
        <div class="bg-orange-100 p-4 rounded-lg text-center">
            <div class="text-3xl font-bold">{{ $qtyIn }}</div>
            <p>Barang Masuk</p>
        </div>
        <div class="bg-orange-100 p-4 rounded-lg text-center">
            <div class="text-3xl font-bold">{{ $qtyOut }}</div>
            <p>Barang Keluar</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-orange-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Grafik Stok per Kategori</h2>
            <canvas id="kategoriChart"></canvas>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold mb-2">Grafik Barang Masuk</h2>
            <canvas id="masukChart"></canvas>
        </div>
        <div class="bg-orange-50 p-4 rounded-lg col-span-2">
            <h2 class="text-lg font-semibold mb-2">Grafik Barang Keluar</h2>
            <canvas id="keluarChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
    const kategoriChart = new Chart(kategoriCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_values($kategoriStok->keys()->toArray())) !!},
            datasets: [{
                label: 'Jumlah',
                data: {!! json_encode(array_values($kategoriStok->values()->toArray())) !!},
                backgroundColor: '#f97316',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    const masukCtx = document.getElementById('masukChart').getContext('2d');
    const masukChart = new Chart(masukCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_values($barangMasukPerBulan->keys()->toArray())) !!},
            datasets: [{
                label: 'Barang Masuk',
                data: {!! json_encode(array_values($barangMasukPerBulan->values()->toArray())) !!},
                backgroundColor: '#34d399',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    const keluarCtx = document.getElementById('keluarChart').getContext('2d');
    const keluarChart = new Chart(keluarCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_values($barangKeluarPerBulan->keys()->toArray())) !!},
            datasets: [{
                label: 'Barang Keluar',
                data: {!! json_encode(array_values($barangKeluarPerBulan->values()->toArray())) !!},
                backgroundColor: '#ef4444',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endpush


