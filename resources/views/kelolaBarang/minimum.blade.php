@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-6">Barang dengan Stok Minimum</h1>

    @if ($identifiers->isEmpty())
        <p class="text-gray-600">Semua barang dalam kondisi cukup.</p>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($identifiers as $identifier => $qty)
            <div class="bg-white border rounded-lg shadow text-center flex flex-col justify-center items-center" style="padding: 25px; width: 200px; height: 200px;">
                <div class="text-4xl font-bold text-red-600 mb-2">{{ $qty }}</div>
                <div class="text-gray-700 text-sm font-semibold uppercase">{{ $identifier }}</div>
            </div>
        @endforeach
    </div>

    @endif
</div>
@endsection
