<!-- filepath: c:\xampp\htdocs\web-koperasi-sankyu\resources\views\generate-pdf\laporan-transakaksi.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Anggota KPT Sankyu</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Keuangan Anggota KPT Sankyu</h2>
    <p>Tanggal: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <p>No. Anggota: <strong>{{ $anggota->id ?? '-' }}</strong></p>
    <p>Nama Anggota: <strong>{{ $anggota->nama_lengkap ?? '-' }}</strong></p>
    <p>Job Site: <strong>{{ $anggota->site ?? '-' }}</strong></p>
    <p>Positions: <strong>{{ $anggota->jabatan ?? '-' }}</strong></p>

    <h3>Data Simpanan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Simpanan</th>
                <th>Jumlah Simpanan</th>
                <th>Tanggal Simpanan</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSimpanan = 0; @endphp
            @foreach($simpanan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucfirst($item->jenis_simpanan) }}</td>
                    <td>Rp {{ number_format($item->jumlah_simpanan, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                </tr>
                @php $totalSimpanan += $item->jumlah_simpanan; @endphp
            @endforeach
            <tr>
                <th colspan="2">Total Simpanan</th>
                <th colspan="2">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <h3>Data Pinjaman</h3>
    <h5>Besaran Cicilan: Rp {{ number_format($cicilan, 0, ',', '.') ?? 0 }}</h5>
    <h5>jangka Waktu: {{ $jangka_waktu ?? "-" }} / Bulan</h5>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jumlah Pinjaman</th>
                <th>Cicilan</th>
                <th>Bunga (%)</th>
                <th>Status</th>
                <th>Tanggal Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPinjaman = 0; @endphp
            @foreach($pinjaman as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->cicilan, 0, ',', '.') }}</td>
                    <td>0.8%</td>
                    <td>{{ ucfirst($item->status_pinjaman) }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}</td>
                </tr>
                @php $totalPinjaman += $item->jumlah_pinjaman; @endphp
            @endforeach
            <tr>
                <th>Total Pinjaman</th>
                <th colspan="5">Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>
