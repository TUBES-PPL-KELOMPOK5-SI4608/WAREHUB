@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto px-6 py-8 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Barang Keluar</h2>

    <form action="{{ route('barang-keluar.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="stock_id" class="block font-medium text-gray-700">Nama Barang</label>
            <select name="stock_id" id="stock_id" class="w-full border border-gray-300 p-2 rounded-md">
                @foreach ($stocks as $stock)
                    <option value="{{ $stock->id }}" {{ (isset($selectedStock) && $selectedStock->id == $stock->id) ? 'selected' : '' }}>
                        {{ $stock->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="date_out" class="block font-medium text-gray-700">Tanggal Keluar</label>
            <input type="date" name="date_out" id="date_out" class="w-full border border-gray-300 p-2 rounded-md">
        </div>

        <div>
            <label for="status" class="block font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full border border-gray-300 p-2 rounded-md">
                <option value="shipping">Shipping</option>
                <option value="pending">Pending</option>
                <option value="book">Book</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
