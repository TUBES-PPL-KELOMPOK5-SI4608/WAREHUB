@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Konfirmasi Pengeluaran Stok</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    @foreach ($rekapStok as $rekap)
        <div class="bg-white border rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">
                {{ $rekap['identifier'] }}
            </h2>
            <p class="text-sm text-gray-600">Akan Dikeluarkan: 
                <span class="font-semibold text-red-600">{{ $rekap['akan_dikeluarkan'] }}</span>
            </p>
            <p class="text-sm text-gray-600">Total Stok: 
                <span class="font-semibold">{{ $rekap['stok_tersedia'] }}</span>
            </p>
            <p class="text-sm text-gray-600">Sisa Setelah Dikeluarkan: 
                <span class="font-semibold text-green-600">{{ $rekap['sisa_setelah'] }}</span>
            </p>
        </div>
    @endforeach
</div>

    <p class="mb-4 text-gray-700">Pastikan data berikut benar sebelum melanjutkan:</p>

    <form method="POST" action="{{ route('stockouts.confirm.store') }}">
        @csrf

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Identifier</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang as $item)
                        <input type="hidden" name="selected_ids[]" value="{{ $item->id }}">
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->name }}</td>
                            <td class="px-4 py-2">{{ $item->identifier }}</td>
                            <td class="px-4 py-2 text-green-600">{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex gap-4">
            <a href="javascript:history.back()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                ← Kembali
            </a>
            <button type="button" onclick="openModal()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">
                 Konfirmasi & Keluarkan Stok
            </button>
        </div>

<div id="confirmModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Isi Informasi Penerima</h2>
        
        <div class="mb-4">
            <label for="recipient_name" class="block text-sm font-medium text-gray-700">Kepada</label>
            <input type="text" name="recipient_name" id="recipient_name" required
                   class="mt-1 w-full border px-3 py-2 rounded shadow-sm focus:ring focus:ring-blue-300">
        </div>

        <div class="mb-4">
            <label for="recipient_address" class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea name="recipient_address" id="recipient_address" rows="3" required
                      class="mt-1 w-full border px-3 py-2 rounded shadow-sm focus:ring focus:ring-blue-300"></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded text-gray-800">
                Batal
            </button>
            <button type="submit" onclick="handleSubmit()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Kirim & Buat Surat Jalan
            </button>
        </div>
    </div>
</div>

    </form>
</div>

<script>
    function openModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }
</script>

<script>
    function handleSubmit() {
        setTimeout(() => {
            window.location.href = '/barang/out';
        }, 9000);
    }
</script>

@endsection
