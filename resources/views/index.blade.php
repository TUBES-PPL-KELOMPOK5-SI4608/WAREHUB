{{-- resources/views/vendors/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Vendor</h1>

        <a href="{{ route('vendors.create') }}" class="btn btn-primary mb-3">+ Tambah Vendor</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($vendors->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->name }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ $vendor->address }}</td>
                            <td>
                                <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-sm btn-info">Lihat</a>
                                <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus vendor ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Belum ada data vendor.</p>
        @endif
    </div>
@endsection
