@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-4">Kerusakan Barang</h1>

    @if (session('success'))
        <div id="alert-success" class="mb-4 bg-green-100 text-green-800 p-3 rounded-lg shadow-sm transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}" class="border rounded px-3 py-1" placeholder="Cari nama retur...">
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded">Cari</button>
        </form>
        <button onclick="document.getElementById('modal-create').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Retur
        </button>
    </div>

    <table class="w-full table-auto border border-gray-300 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Kontak Vendor</th>
                <th class="px-4 py-2 border">Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($returs->sortByDesc('created_at') as $retur)
                <tr>
                    <td class="px-4 py-2 border">
                        <a href="#" class="text-blue-600 hover:underline" onclick='showDetail({!! json_encode($retur) !!})'>
                            {{ $retur->name }}
                        </a>
                    </td>
                    <td class="px-4 py-2 border">
                        <button class="text-indigo-600 underline" onclick="editStatus({{ $retur->id }}, '{{ $retur->status }}')">
                            {{ ucfirst($retur->status) }}
                        </button>
                    </td>
                    <td class="px-4 py-2 border">{{ $retur->vendor->contact ?? '-' }}</td>
                    <td class="px-4 py-2 border text-gray-600">
                        {{ \Carbon\Carbon::parse($retur->created_at)->translatedFormat('d M Y H:i') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    setTimeout(() => {
        const alert = document.getElementById('alert-success');
        if (alert) {
            alert.classList.add('opacity-0');
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>

@include('returs.modal-create')
@include('returs.modal-detail')
@include('returs.modal-status')
@endsection
