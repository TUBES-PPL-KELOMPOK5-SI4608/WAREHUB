@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-4">Audit Barang Keluar</h1>

    <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="text-sm text-gray-700">Dari Tanggal</label>
            <input type="date" name="from" value="{{ request('from') }}"
                   class="w-full border px-3 py-2 rounded shadow-sm">
        </div>
        <div>
            <label class="text-sm text-gray-700">Sampai Tanggal</label>
            <input type="date" name="to" value="{{ request('to') }}"
                   class="w-full border px-3 py-2 rounded shadow-sm">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                🔍 Filter
            </button>
        </div>
    </form>

    <div class="mb-6">
    <a href="{{ route('manager.audit.out.pdf', request()->only(['from', 'to'])) }}"
       target="_blank"
       class="inline-block bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
        🧾 Cetak PDF
    </a>
</div>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-sm text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Barang</th>
                    <th class="px-4 py-3 text-left">Tanggal Keluar</th>
                    <th class="px-4 py-3 text-left">Dibuat Oleh</th>
                    <th class="px-4 py-3 text-left">Diperbarui Oleh</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800 divide-y divide-gray-100">
                @forelse ($items as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->item_name }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">{{ $item->created_with ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->updated_with ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 px-4 py-4">Tidak ada data barang keluar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->appends(request()->only(['from', 'to']))->links() }}
    </div>
</div>
@endsection
