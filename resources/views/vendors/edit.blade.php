@extends('layout.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Data Vendor</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Vendor</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ $vendor->name }}" placeholder="Masukkan nama vendor" required>
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Kontak</label>
                    <input type="text" name="contact" id="contact" class="form-control" 
                           value="{{ $vendor->contact }}" placeholder="Masukkan kontak vendor" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                    <button type="submit" class="btn btn-primary">Simpan Vendor</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
