<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Jalan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header, .info, .table { margin-bottom: 20px; }
        .header-title { font-size: 16px; font-weight: bold; }
        .info td { padding: 4px 8px; vertical-align: top; }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .table { border-collapse: collapse; width: 100%; }
    </style>
</head>
<body>

    <table width="100%" class="header">
        <tr>
            <td width="50%">
                <div class="header-title">WAREHUB</div>
                Jalan Salemba No 27<br>
                Jakarta Pusat<br><br>
                Nomor Surat: {{ $stockout->id }}<br>
                Dibuat Oleh: {{ $stockout->created_with }}
            </td>
            <td width="50%" align="right">
                <div class="header-title">SURAT JALAN</div>
                Tanggal: {{ \Carbon\Carbon::parse($stockout->date)->format('d-m-Y') }}<br>
                Kepada: {{ str_replace('+', ' ', $recipient_name) }}<br>
                Alamat: {{ $recipient_address }}
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Barang</th>
                <th>Nama Barang</th>
                <th>Identifier</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->identifier }}</td>
                <td>{{ $item->description ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
