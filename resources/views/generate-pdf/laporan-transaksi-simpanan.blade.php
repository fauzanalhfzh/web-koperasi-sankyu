<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Simpanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Laporan Transaksi Simpanan</h1>
    <p>Bulan:
        @if ($bulan == 'all')
        Seluruh Tahun {{ $tahun }}
        @else
        {{ \Carbon\Carbon::createFromFormat('m', $bulan)->format('F') }} {{ $tahun }}
        @endif
    </p>
    <table>
        <thead>
            <tr>
                <th>Tanggal Transaksi</th>
                <th>Nama Anggota</th>
                <th>Jumlah Simpanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($simpanan as $s)
            <tr>
                <td>{{ \Carbon\Carbon::parse($s->tanggal_transaksi)->format('d-m-Y') }}</td>
                <td>{{ $s->member->nama_lengkap ?? '-' }}</td>
                <td>Rp {{ number_format($s->jumlah_simpanan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>