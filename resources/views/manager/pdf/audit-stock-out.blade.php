<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Audit Barang Keluar</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2 { margin-bottom: 0; }
        .meta { font-size: 12px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Audit Barang Keluar</h2>
    <p class="meta">Periode: {{ $from ?? 'Semua' }} - {{ $to ?? 'Semua' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Tanggal Keluar</th>
                <th>Dibuat Oleh</th>
                <th>Diperbarui Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                <td>{{ $item->created_with ?? '-' }}</td>
                <td>{{ $item->updated_with ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
