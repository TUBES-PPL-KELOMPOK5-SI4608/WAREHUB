@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Barang Keluar</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-6 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..."
               class="w-full sm:w-1/2 px-4 py-2 border rounded shadow-sm">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🔍 Cari
        </button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($inventories as $barang)
            <div class="bg-white border rounded-lg shadow p-4">
                <img src="{{ $barang->picture_1 ? asset('storage/' . $barang->picture_1) : 'https://via.placeholder.com/150' }}"
                     alt="Gambar Barang"
                     class="w-full h-40 object-cover rounded mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $barang->name }}</h3>
                <form method="POST" action="{{ route('stockouts.store', $barang->id) }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded">
                        Keluarkan Stok
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-600 col-span-full">Tidak ada barang ditemukan.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $inventories->links() }}
    </div>
</div>
@endsection
