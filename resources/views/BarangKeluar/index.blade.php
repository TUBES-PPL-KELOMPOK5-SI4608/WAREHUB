@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Daftar Barang Keluar</h2>

    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-3 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Nama Barang</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Tanggal Keluar</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($barangKeluars as $index => $item)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $item->stock->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $item->date_out }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 capitalize">{{ $item->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
