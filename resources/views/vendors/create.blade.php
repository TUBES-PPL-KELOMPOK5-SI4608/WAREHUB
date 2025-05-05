@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-xl font-semibold mb-6">Tambah Vendor Baru</h2>

    <form action="{{ route('vendors.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium">Nama Vendor</label>
            <input type="text" name="name" id="name" required
                   placeholder="Masukkan nama vendor"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div>
            <label for="contact" class="block text-sm font-medium">Kontak</label>
            <input type="text" name="contact" id="contact" required
                   placeholder="Masukkan kontak vendor"
                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
        </div>

        <div class="flex justify-between pt-4">
            <a href="{{ route('vendors.index') }}"
               class="text-sm underline hover:no-underline">
                ← Kembali ke Daftar
            </a>
            <button type="submit"
                    class="text-sm px-4 py-2 border border-gray-400 rounded hover:bg-gray-100">
                Simpan Vendor
            </button>
        </div>
    </form>
</div>
@endsection
