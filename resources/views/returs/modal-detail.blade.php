<div id="modal-detail" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-xl p-6 relative">
        <button onclick="document.getElementById('modal-detail').classList.add('hidden')" class="absolute top-3 right-3 text-gray-600 hover:text-black">✖</button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">📄 Detail Retur</h2>
        <div class="space-y-2 text-gray-700">
            <p><strong>Nama:</strong> <span id="detail-name"></span></p>
            <p><strong>Deskripsi:</strong> <span id="detail-description"></span></p>
            <p><strong>Status:</strong> <span id="detail-status"></span></p>
            <p><strong>Vendor:</strong> <span id="detail-vendor"></span></p>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-4">
            <img id="detail-picture1" class="w-full h-40 object-cover rounded" alt="Foto 1">
            <img id="detail-picture2" class="w-full h-40 object-cover rounded" alt="Foto 2">
        </div>
    </div>
</div>

<script>
    function showDetail(retur) {
        document.getElementById('detail-name').textContent = retur.name ?? '-';
        document.getElementById('detail-description').textContent = retur.description ?? '-';
        document.getElementById('detail-status').textContent = retur.status ?? '-';
        document.getElementById('detail-vendor').textContent = retur.vendor?.name ?? '-';
        document.getElementById('detail-picture1').src = retur.picture_1 ? `/storage/${retur.picture_1}` : 'https://via.placeholder.com/150';
        document.getElementById('detail-picture2').src = retur.picture_2 ? `/storage/${retur.picture_2}` : 'https://via.placeholder.com/150';
        document.getElementById('modal-detail').classList.remove('hidden');
    }
</script>
