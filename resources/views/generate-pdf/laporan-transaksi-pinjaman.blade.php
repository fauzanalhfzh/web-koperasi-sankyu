<!-- resources/views/generate-pdf/laporan-transaksi-pinjaman.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pinjaman Anggota</title>
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
    <h2>Laporan Pinjaman Anggota Koperasi Karyawan PT Sankyu Internasional Indonesia</h2>
    <p>Bulan:
        @if ($bulan == 'all')
        Seluruh Tahun {{ $tahun }}
        @else
        {{ \Carbon\Carbon::createFromFormat('m', $bulan)->format('F') }} {{ $tahun }}
        @endif
    </p>

    <h3>Data Pinjaman Seluruh Anggota</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pinjaman</th>
                <th>Nama Anggota</th>
                <th>Jumlah Pinjaman</th>
                <th>Bunga (%)</th>
                <th>Cicilan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPinjaman = 0; @endphp
            @foreach($pinjaman as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}</td>
                <td>{{ $item->member->nama_lengkap ?? '-' }}</td>
                <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                <td>{{ $item->bunga }}</td>
                <td>Rp {{ number_format($item->cicilan, 0, ',', '.') }}</td>
                <td>{{ ucfirst($item->status_pinjaman) }}</td>
            </tr>
            @php $totalPinjaman += $item->jumlah_pinjaman; @endphp
            @endforeach
            <tr>
                <th colspan="2">Total Pinjaman</th>
                <th colspan="5">Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
</body>

</html>