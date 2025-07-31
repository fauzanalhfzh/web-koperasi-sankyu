<!-- filepath: c:\xampp\htdocs\web-koperasi-sankyu\resources\views\generate-pdf\laporan-transakaksi.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan KPT Sankyu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <h2>Laporan Simpanan Anggota Koperasi Karyawan PT Sankyu Internasional Indonesia</h2>
    <p>Tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

    <h3>Data Simpanan Seluruh Anggota</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Simpanan</th>
                <th>Nama Anggota</th>
                <th>Jumlah Simpanan</th>
                <th>Jenis Simpanan</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSimpanan = 0; @endphp
            @foreach($simpanan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                <td>{{ $item->member->nama_lengkap ?? '-' }}</td>
                <td>Rp {{ number_format($item->jumlah_simpanan, 0, ',', '.') }}</td>
                <td>{{ ucfirst($item->jenis_simpanan) }}</td>
            </tr>
            @php $totalSimpanan += $item->jumlah_simpanan; @endphp
            @endforeach
            <tr>
                <th colspan="3">Total Simpanan</th>
                <th colspan="2">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
</body>

</html>