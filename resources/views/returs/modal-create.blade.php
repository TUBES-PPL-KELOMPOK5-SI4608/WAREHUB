<div id="modal-create" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">➕ Tambah Retur</h2>

        <form action="{{ route('returs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Nama Barang</label>
                    <input type="text" name="name" required class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Vendor</label>
                    <select name="id_vendor" required class="w-full border px-3 py-2 rounded">
                        <option value="">Pilih Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600">Foto 1</label>
                    <input type="file" name="picture_1" accept="image/*" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Foto 2</label>
                    <input type="file" name="picture_2" accept="image/*" class="w-full">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
