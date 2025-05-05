@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-2xl font-bold mb-6">Notifikasi Stocks</h1>

    <form method="GET" class="mb-6">
        <label for="date" class="mr-2 font-medium">Filter Tanggal:</label>
        <input type="date" name="date" id="date" value="{{ $tanggal }}" class="border rounded px-3 py-1">
        <button type="submit" class="ml-2 bg-blue-600 text-white px-3 py-1 rounded">Terapkan</button>
    </form>

    <h2 class="text-xl font-semibold text-gray-700 mb-4">📦 Barang Masuk</h2>
    @forelse ($inventories as $item)
        <div class="bg-white border-l-4 border-blue-500 p-4 mb-3 rounded shadow-sm">
            <p class="text-gray-800">
                <strong>{{ $item->created_with ?? '-' }}</strong>
                {{ $item->created_at == $item->updated_at ? 'menambahkan' : 'memperbarui' }}
                barang <strong>{{ $item->name }}</strong>
            </p>
            <p class="text-sm text-gray-500">{{ $item->updated_at->format('d M Y H:i:s') }}</p>
        </div>
    @empty
        <p class="text-gray-500 italic mb-6">Tidak ada aktivitas inventaris.</p>
    @endforelse

    <h2 class="text-xl font-semibold text-gray-700 mt-8 mb-4">📤 Stock Out</h2>
    @forelse ($stockOuts as $item)
        <div class="bg-white border-l-4 border-red-500 p-4 mb-3 rounded shadow-sm">
            <p class="text-gray-800">
                <strong>{{ $item->created_with ?? '-' }}</strong> mengeluarkan stok untuk
                <strong>{{ $item->inventory->name ?? 'Barang tidak ditemukan' }}</strong>
            </p>
            <p class="text-sm text-gray-500">{{ $item->updated_at->format('d M Y H:i:s') }}</p>
        </div>
    @empty
        <p class="text-gray-500 italic">Tidak ada aktivitas stock out.</p>
    @endforelse

</div>
@endsection
