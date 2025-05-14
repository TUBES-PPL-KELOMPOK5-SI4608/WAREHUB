@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Barang Rusak</h2>

    @if ($defectItems->isEmpty())
        <p class="text-gray-600">Tidak ada barang yang statusnya defect.</p>
    @else
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full text-sm text-left text-gray-800 border border-gray-300">
                <thead class="bg-gray-700 text-white text-center">
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-300">Nama</th>
                        <th class="px-4 py-3 border-b border-gray-300">Identifier</th>
                        <th class="px-4 py-3 border-b border-gray-300">Deskripsi</th>
                        <th class="px-4 py-3 border-b border-gray-300">Vendor</th>
                        <th class="px-4 py-3 border-b border-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($defectItems as $item)
                        <tr>
                            <td class="px-4 py-3 text-center">
                                <a href="javascript:void(0)" onclick="openEditModal({{ json_encode($item) }})" class="text-blue-600 hover:text-blue-800">{{ $item->name }}</a>
                            </td>
                            <td class="px-4 py-3 text-center">{{ $item->identifier }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->description }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->vendor_name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Modal Edit -->
<div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-5xl w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Edit Barang Rusak</h2>

        <form action="{{ route('barangs.update', 'placeholder') }}" method="POST" id="edit-barang-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" id="modal-item-id" name="id">

            <div class="mb-4">
                <label for="modal-item-name" class="block text-sm font-medium text-gray-700">Nama Barang:</label>
                <input type="text" id="modal-item-name" name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="modal-item-identifier" class="block text-sm font-medium text-gray-700">Identifier:</label>
                <input type="text" id="modal-item-identifier" name="identifier" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="modal-item-description" class="block text-sm font-medium text-gray-700">Deskripsi:</label>
                <textarea id="modal-item-description" name="description" rows="4" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div class="mb-4">
                <label for="modal-item-vendor" class="block text-sm font-medium text-gray-700">Vendor:</label>
                <input type="text" id="modal-item-vendor" name="vendor_name" class="w-full border rounded px-3 py-2" disabled>
            </div>

            <div class="mb-4">
                <label for="modal-item-status" class="block text-sm font-medium text-gray-700">Status:</label>
                <select id="modal-item-status" name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="available">Available</option>
                    <option value="defect">Defect</option>
                </select>
            </div>

            <!-- Display photos flexibly in two columns -->
            <div class="mb-4 flex space-x-4">
                <div class="flex flex-col items-center w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Foto Barang 1:</label>
                    <img id="modal-item-picture-1-img" class="object-contain w-32 h-32 mt-2" src="" alt="Foto Barang 1">
                </div>
                <div class="flex flex-col items-center w-1/2">
                    <label class="block text-sm font-medium text-gray-700">Foto Barang 2:</label>
                    <img id="modal-item-picture-2-img" class="object-contain w-32 h-32 mt-2" src="" alt="Foto Barang 2">
                </div>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
                <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Tutup</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(item) {
    document.getElementById('modal-item-id').value = item.id;
    document.getElementById('modal-item-name').value = item.name;
    document.getElementById('modal-item-identifier').value = item.identifier;
    document.getElementById('modal-item-description').value = item.description;
    document.getElementById('modal-item-status').value = item.status;
    document.getElementById('modal-item-vendor').value = item.vendor_name;

    document.getElementById('modal-item-picture-1-img').src = item.picture_1 ? "/storage/" + item.picture_1 : "";
    document.getElementById('modal-item-picture-2-img').src = item.picture_2 ? "/storage/" + item.picture_2 : "";

    document.getElementById('edit-barang-form').action = "/barang/defect/update/" + item.id;

    document.getElementById('edit-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}
</script>
@endsection
