@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Vendor Warehub</h2>
        <a href="{{ route('vendors.create') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Vendor
        </a>
    </div>

    @if(session('success'))
        <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-500 ease-out">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($vendors->count())
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full text-sm text-left text-gray-800 border border-gray-300">
                <thead class="bg-gray-700 text-white text-center">
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-300">Nama</th>
                        <th class="px-4 py-3 border-b border-gray-300">Telepon</th>
                        <th class="px-4 py-3 border-b border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vendors as $vendor)
                        <tr>
                            <td class="px-4 text-center py-3">{{ $vendor->name }}</td>
                            <td class="px-4 text-center py-3">{{ $vendor->contact }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <!-- Lihat Button for Modal -->
                                <button type="button" class="inline-block px-2 py-1 text-blue-600 hover:text-blue-800 border border-blue-500 rounded"
                                    onclick="openModal('{{ $vendor->name }}', '{{ $vendor->contact }}')">
                                    Lihat
                                </button>
                                <a href="{{ route('vendors.edit', $vendor) }}"
                                   class="inline-block px-2 py-1 text-yellow-600 hover:text-yellow-800 border border-yellow-500 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus vendor ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-block px-2 py-1 text-red-600 hover:text-red-800 border border-red-500 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-gray-600 mt-6">
            Belum ada data vendor yang tersedia.
        </div>
    @endif
</div>

<div id="vendorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Vendor</h2>
        <p><strong>Nama:</strong> <span id="vendorName"></span></p>
        <p><strong>Kontak:</strong> <span id="vendorContact"></span></p>
        <div class="flex justify-end mt-4">
            <button id="closeModal" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Tutup</button>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.classList.add('opacity-0');
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>
@endif

<script>
    function openModal(name, contact) {
        document.getElementById('vendorName').innerText = name;
        document.getElementById('vendorContact').innerText = contact;
        document.getElementById('vendorModal').classList.remove('hidden');
    }

    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('vendorModal').classList.add('hidden');
    });
</script>
@endsection
