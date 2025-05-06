<!-- Modal Edit -->
<div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Edit Barang Rusak</h2>

        <form action="{{ route('barangs.update', 'placeholder') }}" method="POST" id="edit-barang-form">
            @csrf
            @method('PUT')

            <!-- Hidden Item ID -->
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
                <select id="modal-item-vendor" name="id_vendor" class="w-full border rounded px-3 py-2" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="modal-item-status" class="block text-sm font-medium text-gray-700">Status:</label>
                <select id="modal-item-status" name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="available">Available</option>
                    <option value="defect">Defect</option>
                </select>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Simpan Perubahan</button>
                <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md">Tutup</button>
            </div>
        </form>
    </div>
</div>
