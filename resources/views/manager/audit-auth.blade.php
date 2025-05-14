@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold mb-4">Audit Autentikasi Admin</h1>

    <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="text-sm text-gray-700">Dari Tanggal</label>
            <input type="date" name="from" value="{{ $from }}"
                   class="w-full border px-3 py-2 rounded shadow-sm">
        </div>
        <div>
            <label class="text-sm text-gray-700">Sampai Tanggal</label>
            <input type="date" name="to" value="{{ $to }}"
                   class="w-full border px-3 py-2 rounded shadow-sm">
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                🔍 Filter
            </button>
        </div>
    </form>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-sm text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Waktu</th>
                    <th class="px-4 py-3 text-left">Username Admin</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                    <th class="px-4 py-3 text-left">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800 divide-y divide-gray-100">
                @forelse ($logs as $log)
                    <tr>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($log->created_at)->format('d-m-Y H:i:s') }}</td>
                        <td class="px-4 py-2">{{ $log->user_name }}</td>
                        <td class="px-4 py-2 capitalize">{{ $log->action }}</td>
                        <td class="px-4 py-2 capitalize">{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-500 px-4 py-4">Tidak ada log ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->appends(['from' => $from, 'to' => $to])->links() }}
    </div>
</div>
@endsection
