@extends('layouts.main')

@section('content')
@php
    $selectedIds = request()->input('selected_ids', []);
@endphp

<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Barang Keluar</h1>

    @if (session('success'))
        <div id="alert-success" class="mb-4 bg-green-100 text-green-800 p-3 rounded-lg shadow-sm transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-6 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
        @foreach ($selectedIds as $id)
            <input type="hidden" name="selected_ids[]" value="{{ $id }}">
        @endforeach

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau identifier"
               class="w-full sm:w-1/2 px-4 py-2 border rounded shadow-sm">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🔍 Cari
        </button>
    </form>


    <form method="POST" action="{{ route('stockouts.confirm') }}">
        @csrf
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Identifier</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($inventories as $barang)
                        <tr>
                            <td class="px-4 py-2">
                                <input type="checkbox" name="selected_ids[]" value="{{ $barang->id }}"
                                    class="checkbox-item w-4 h-4 text-red-600 rounded border-gray-300"
                                    {{ in_array($barang->id, $selectedIds) ? 'checked' : '' }}>
                            </td>
                            <td class="px-4 py-2">
                                <img src="{{ $barang->picture_1 ? asset('storage/' . $barang->picture_1) : 'https://via.placeholder.com/100' }}"
                                     alt="Gambar Barang"
                                     class="w-20 h-16 object-cover rounded">
                            </td>
                            <td class="px-4 py-2 text-gray-800">{{ $barang->name }}</td>
                            <td class="px-4 py-2 text-gray-800">{{ $barang->identifier }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500">Tidak ada barang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-right">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded shadow-lg text-lg">
                Keluarkan Stok yang Dipilih
            </button>
        </div>
    </form>

    <div class="mt-6">
        {{ $inventories->appends(request()->query())->links() }}
    </div>
</div>

<script>
    document.getElementById('selectAll')?.addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(cb => cb.checked = e.target.checked);
    });
</script>

<script>
    setTimeout(() => {
        const alert = document.getElementById('alert-success');
        if (alert) {
            alert.classList.add('opacity-0');
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>

<script>
    const STORAGE_KEY = 'selected_ids';

    // Ambil checkbox tercentang dari localStorage
    function getSelectedIds() {
        return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    }

    // Simpan ulang ke localStorage
    function setSelectedIds(ids) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
    }

    // Inisialisasi
    const checkboxes = document.querySelectorAll('.checkbox-item');
    const selectedIds = new Set(getSelectedIds());

    // Cek checkbox berdasarkan localStorage
    checkboxes.forEach(cb => {
        if (selectedIds.has(cb.value)) {
            cb.checked = true;
        }

        cb.addEventListener('change', function () {
            if (cb.checked) {
                selectedIds.add(cb.value);
            } else {
                selectedIds.delete(cb.value);
            }
            setSelectedIds([...selectedIds]);
        });
    });

    // Saat form submit, injeksikan hidden input berdasarkan selectedIds
    document.querySelector('form[action="{{ route('stockouts.confirm') }}"]')
        .addEventListener('submit', function (e) {
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_ids[]';
                input.value = id;
                this.appendChild(input);
            });

            // Hapus dari localStorage setelah submit
            localStorage.removeItem(STORAGE_KEY);
        });
</script>

@endsection
