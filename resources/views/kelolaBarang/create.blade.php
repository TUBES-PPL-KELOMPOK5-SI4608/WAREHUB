@extends('layouts.main')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">

        <!-- Header dan tombol kembali -->
        <div class="flex justify-between items-center mb-6 border-b pb-2">
            <h2 class="text-2xl font-bold text-[#74512D]">Tambah Barang</h2>
            <a href="{{ route('barangs.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded shadow text-sm font-medium">
                Kembali ke Daftar Barang
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barangs.store') }}" method="POST" id="form-barang" enctype='multipart/form-data'>
            @csrf

            <div id="barang-wrapper" class="space-y-6">
                <div class="barang-input bg-[#FBFAF5] p-6 border border-gray-300 rounded-lg shadow relative">
                    <h3 class="text-lg font-semibold mb-4 text-[#74512D]">Barang #1</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Nama Barang</label>
                            <input type="text" name="barang[0][name]" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi</label>
                            <input type="text" name="barang[0][description]" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Identifier</label>
                            <select name="barang[0][identifier]" class="w-full border rounded px-3 py-2" required>
                                <option value="" disabled selected>Pilih Identifier</option>
                                @foreach ($identifiers as $identifier)
                                    <option value="{{ $identifier }}">{{ $identifier }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Vendor</label>
                            <select name="barang[0][vendor]" class="w-full border rounded px-3 py-2" required>
                                <option value="" disabled selected>Pilih Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Foto 1</label>
                            <input type="file" name="barang[0][picture_1]" class="w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Foto 2</label>
                            <input type="file" name="barang[0][picture_2]" class="w-full border rounded px-3 py-2">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol tambah -->
            <button type="button" id="add-barang" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                + Tambah Barang Lagi
            </button>

            <!-- Tombol submit -->
            <div class="mt-8">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded text-lg font-semibold shadow-md">
                    Simpan Semua Barang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let index = 1;
    const vendors = @json($vendors);
    const identifiers = @json($identifiers);

    document.getElementById('add-barang').addEventListener('click', function () {
        const wrapper = document.getElementById('barang-wrapper');
        const newCard = document.createElement('div');
        newCard.classList = 'barang-input bg-[#FBFAF5] p-6 border border-gray-300 rounded-lg shadow relative mt-4';

        // Vendor options
        let vendorOptions = '<option value="" disabled selected>Pilih Vendor</option>';
        vendors.forEach(v => {
            vendorOptions += `<option value="${v.id}">${v.name}</option>`;
        });

        // Identifier options
        let identifierOptions = '<option value="" disabled selected>Pilih Identifier</option>';
        identifiers.forEach(i => {
            identifierOptions += `<option value="${i}">${i}</option>`;
        });

        newCard.innerHTML = `
            <h3 class="text-lg font-semibold mb-4 text-[#74512D]">Barang #${index + 1}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" name="barang[${index}][name]" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi</label>
                    <input type="text" name="barang[${index}][description]" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Identifier</label>
                    <select name="barang[${index}][identifier]" class="w-full border rounded px-3 py-2" required>
                        ${identifierOptions}
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Vendor</label>
                    <select name="barang[${index}][vendor]" class="w-full border rounded px-3 py-2" required>
                        ${vendorOptions}
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Foto 1</label>
                    <input type="file" name="barang[${index}][picture_1]" class="w-full border rounded px-3 py-2" >
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Foto 2</label>
                    <input type="file" name="barang[${index}][picture_2]" class="w-full border rounded px-3 py-2" >
                </div>
            </div>
        `;

        wrapper.appendChild(newCard);
        index++;
    });
</script>
@endsection
