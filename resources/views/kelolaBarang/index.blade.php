@extends('layouts.main')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Barang</h2>
        <a href="{{ route('barangs.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md shadow">
            + Tambah Barang
        </a>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-3 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('barangs.index') }}" method="GET" class="mb-6 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." class="w-full sm:w-1/2 px-4 py-2 border rounded-md shadow-sm">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            🔍 Cari
        </button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($barangs as $barang)
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition relative">
                
                @if ($barang->picture_1)
                    <img src="{{ asset('storage/' . $barang->picture_1) }}" 
                         alt="Gambar 1" 
                         class="rounded-lg w-full h-40 object-cover cursor-pointer" 
                         onclick="openModal('{{ asset('storage/' . $barang->picture_1) }}', '{{ asset('storage/' . $barang->picture_2) }}')">
                @endif

                <h3 class="text-xl font-semibold text-blue-700 mt-4">{{ $barang->name }}</h3>
                
                <div class="text-sm text-gray-600 mb-2 mt-2">
                    <p><strong>Deskripsi:</strong> {{ $barang->description }}</p>
                    <p><strong>Vendor:</strong> {{ $barang->vendor->name ?? '-' }}</p>
                </div>

                <div class="flex justify-between mt-4">
                    <a href="{{ route('barangs.edit', $barang->id) }}" class="text-sm bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                        ✏️ Edit
                    </a>
                    <form data-barang-id="{{ $barang->id }}" class="form-hapus-barang">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-hapus text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="modal-konfirmasi" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Penghapusan</h2>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus barang ini?</p>
        <div class="flex justify-end gap-3">
            <button id="batal-btn" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
            <form id="form-konfirmasi" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div id="modal-gambar" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden opacity-0 transition-opacity duration-500">
    <div class="bg-white rounded-lg overflow-hidden shadow-lg w-full max-w-md scale-95 transform transition-transform duration-500">
        <div class="relative">
            <img id="gambar-preview" src="" class="w-full object-cover h-80 transition-transform duration-300 hover:scale-110">
            <button onclick="closeModal()" class="absolute top-2 right-2 bg-gray-800 text-white rounded-full p-2 hover:bg-gray-700">
                ✖️
            </button>
        </div>
        <div class="flex justify-center gap-4 bg-gray-100 p-4">
            <img id="gambar-1" src="" class="w-20 h-20 object-cover rounded cursor-pointer border-2">
            <img id="gambar-2" src="" class="w-20 h-20 object-cover rounded cursor-pointer border-2">
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('modal-konfirmasi');
    const formKonfirmasi = document.getElementById('form-konfirmasi');
    const batalBtn = document.getElementById('batal-btn');

    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.form-hapus-barang');
            const action = form.getAttribute('action') || `/barangs/${form.dataset.barangId}`;
            formKonfirmasi.setAttribute('action', action);
            modal.classList.remove('hidden');
        });
    });

    batalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
        formKonfirmasi.setAttribute('action', '');
    });

    const modalGambar = document.getElementById('modal-gambar');
    const gambarPreview = document.getElementById('gambar-preview');
    const gambar1 = document.getElementById('gambar-1');
    const gambar2 = document.getElementById('gambar-2');

    function openModal(src1, src2) {
        modalGambar.classList.remove('hidden');
        setTimeout(() => {
            modalGambar.classList.remove('opacity-0');
        }, 10);

        gambarPreview.src = src1;
        gambar1.src = src1;
        gambar2.src = src2;

        setActiveThumbnail(gambar1, gambar2);
    }

    function closeModal() {
        modalGambar.classList.add('opacity-0');
        setTimeout(() => {
            modalGambar.classList.add('hidden');
            gambarPreview.src = '';
            gambar1.src = '';
            gambar2.src = '';
        }, 500);
    }

    function setActiveThumbnail(active, inactive) {
        active.classList.add('border-4', 'border-blue-500', 'shadow-md');
        active.classList.remove('border-2');

        inactive.classList.remove('border-4', 'border-blue-500', 'shadow-md');
        inactive.classList.add('border-2');
    }

    gambar1.onclick = () => {
        gambarPreview.src = gambar1.src;
        setActiveThumbnail(gambar1, gambar2);
    };

    gambar2.onclick = () => {
        gambarPreview.src = gambar2.src;
        setActiveThumbnail(gambar2, gambar1);
    };
</script>
@endsection
