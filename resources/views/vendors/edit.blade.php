@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Data Vendor</h2>
    </div>

    <form action="{{ route('vendors.update', $vendor->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Vendor</label>
            <input type="text" name="name" id="name" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                   value="{{ $vendor->name }}" placeholder="Masukkan nama vendor" required>
        </div>

        <div>
            <label for="contact" class="block text-sm font-medium text-gray-700">Kontak</label>
            <input type="text" name="contact" id="contact" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                   value="{{ $vendor->contact }}" placeholder="Masukkan kontak vendor" required>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('vendors.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                Kembali ke Daftar
            </a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Simpan Vendor
            </button>
        </div>
    </form>
</div>
@endsection
