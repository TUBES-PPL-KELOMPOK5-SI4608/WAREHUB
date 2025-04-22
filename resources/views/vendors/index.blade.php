@extends('layout.layout')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Daftar Vendor
        </div>
        <div class="card-body">

            {{-- Tampilkan pesan sukses --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('vendors.create') }}" class="btn btn-success mb-3">+ Tambah Vendor Baru</a>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px">No</th>
                        <th style="width: 500px">Nama Vendor</th>
                        <th style="width: 500px">Kontak</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->contact }}</td>
                            <td>
                                <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus vendor ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data vendor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
