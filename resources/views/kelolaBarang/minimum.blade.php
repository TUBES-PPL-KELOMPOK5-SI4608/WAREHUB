@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
<h1 class="text-2xl font-bold mb-2">Rekap Stok Barang</h1><br>
<button onclick="document.getElementById('addModal').classList.remove('hidden')" 
    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
    + Tambah Identifier
</button>

    @if ($identifiers->isEmpty())
        <p class="text-gray-600">Belum ada data barang tersedia.</p>
    @else
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">#</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Identifier</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Batas Kuantitas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($identifiers as $identifier => $data)
                    @php
                        $qty = $data['qty'];
                        $limit = $data['limit'];
                        $color = $qty >= $limit ? 'text-green-600' : 'text-red-600';
                    @endphp
                    <tr>
                        <td class="px-4 py-2 text-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-blue-700 font-semibold cursor-pointer underline"
                            onclick="openEditModal('{{ $identifier }}', {{ $data['limit'] }})">
                            {{ $identifier }}
                        </td>
                        <td class="px-4 py-2 font-semibold {{ $color }}">{{ $qty }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $limit }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    @endif
</div>

<div id="addModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
        <h2 class="text-xl font-semibold mb-4">Tambah Identifier</h2>
        <form action="{{ route('identifiers.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Identifier</label>
                <input type="text" name="identifier" required class="mt-1 block w-full border-gray-300 rounded shadow-sm px-3 py-2 focus:ring focus:ring-blue-200">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Batas Kuantitas</label>
                <input type="number" name="quantity" required min="0" class="mt-1 block w-full border-gray-300 rounded shadow-sm px-3 py-2 focus:ring focus:ring-blue-200">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Simpan
                </button>
            </div>
        </form>
        <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-black">
            &times;
        </button>
    </div>
</div>


<div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
        <h2 class="text-xl font-semibold mb-4">Edit Identifier</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="identifier" id="editIdentifierValue">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Identifier</label>
                <input type="text" id="editIdentifier" name="edit_identifier" class="mt-1 block w-full bg-gray-100 border-gray-300 rounded shadow-sm px-3 py-2" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Batas Kuantitas</label>
                <input type="number" name="quantity" id="editQuantity" required min="0" class="mt-1 block w-full border-gray-300 rounded shadow-sm px-3 py-2">
            </div>
            <div class="flex justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="deleteIdentifier()" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                    Hapus
                </button>
            </div>
        </form>
        <button onclick="document.getElementById('editModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-black">
            &times;
        </button>
    </div>
</div>


<script>
function openEditModal(identifier, quantity) {
    document.getElementById('editIdentifier').value = identifier;
    document.getElementById('editQuantity').value = quantity;
    document.getElementById('editIdentifierValue').value = identifier;
    
    document.getElementById('editForm').action = `/identifiers/update/${identifier}`;

    document.getElementById('editModal').classList.remove('hidden');
}

function deleteIdentifier() {
    let identifier = document.getElementById('editIdentifierValue').value;
    if (confirm(`Yakin ingin menghapus identifier "${identifier}"?`)) {
        window.location.href = `/identifiers/delete/${identifier}`;
    }
}
</script>

@endsection
