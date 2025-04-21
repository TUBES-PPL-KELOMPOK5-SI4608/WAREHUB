@extends('layout.layout')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Daftar Vendor
        </div>
        <div class="card-body">
            <a href="{{ route('vendors.create') }}" class="btn btn-success mb-3">+ Tambah Vendor Baru</a>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px">No</th>
                        <th style="width: 500px">Nama Vendor</th>
                        <th style="width: 500px">Kontak</th>
                        <th style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $vendor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->contact }}</td>
                            <td>
                                <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-sm btn-warning mr-3">Edit</a>
                                <a href="{{ route('vendors.destroy', $vendor->id) }}" class="btn btn-sm btn-danger ml-3">Hapus</a>
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
