<div id="modal-status" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-sm p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">🔧 Perbarui Status</h2>
        <form id="status-form" method="POST">
            @csrf
            <select name="status" id="status-select" required class="w-full border px-3 py-2 rounded mb-4">
                <option value="pending">Pending</option>
                <option value="in progress">In Progress</option>
                <option value="done">Done</option>
            </select>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('modal-status').classList.add('hidden')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editStatus(id, currentStatus) {
        const modal = document.getElementById('modal-status');
        const form = document.getElementById('status-form');
        const select = document.getElementById('status-select');
        select.value = currentStatus;
        form.action = `/admin/returs/${id}/status`;
        modal.classList.remove('hidden');
    }
</script>
