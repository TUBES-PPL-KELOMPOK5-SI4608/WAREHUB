@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-2xl font-bold text-[#74512D] mb-6">Edit Barang</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barangs.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Nama Barang:</label>
                    <input type="text" name="name" value="{{ old('name', $barang->name) }}" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Identifier:</label>
                    <input type="text" name="identifier" value="{{ old('identifier', $barang->identifier) }}" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi:</label>
                    <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $barang->description) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 text-sm font-medium text-gray-700">Vendor:</label>
                    <input type="text" name="id_vendor" value="{{ old('id_vendor', $barang->id_vendor) }}" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mt-6">
                <label class="block mb-2 text-sm font-medium text-gray-700">Foto Barang 1 (optional):</label>
                @if ($barang->picture_1)
                    <img src="{{ asset('storage/' . $barang->picture_1) . '?' . time() }}" 
                         alt="Gambar Barang 1" 
                         class="w-32 h-32 object-cover rounded mb-2">
                @endif
                <input type="file" name="picture_1" class="block w-full text-sm text-gray-600">
            </div>

            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">Foto Barang 2 (optional):</label>
                @if ($barang->picture_2)
                    <img src="{{ asset('storage/' . $barang->picture_2) . '?' . time() }}" 
                         alt="Gambar Barang 2" 
                         class="w-32 h-32 object-cover rounded mb-2">
                @endif
                <input type="file" name="picture_2" class="block w-full text-sm text-gray-600">
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-lg font-semibold shadow-md">
                    Simpan Perubahan
                </button>
                <a href="{{ route('barangs.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded text-lg font-medium shadow">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
