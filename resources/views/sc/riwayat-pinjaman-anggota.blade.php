<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Steering Committee - Koperasi PT. Sankyu</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Riwayat Pinjaman - {{ $member->nama_lengkap }}</h1>

        <a href="{{ route('sc.dashboard') }}" class="mb-4 inline-block text-blue-600 hover:underline">← Kembali</a>


        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-gray-500 font-medium">Tanggal</th>
                        <th class="px-6 py-3 text-left text-gray-500 font-medium">Jumlah</th>
                        <th class="px-6 py-3 text-left text-gray-500 font-medium">Cicilan</th>
                        <th class="px-6 py-3 text-left text-gray-500 font-medium">Jangka Waktu</th>
                        <th class="px-6 py-3 text-left text-gray-500 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($riwayatPinjaman as $pinjaman)
                    <tr>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($pinjaman->cicilan, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $pinjaman->jangka_waktu }} Bulan</td>
                        <td class="px-6 py-4 capitalize">{{ $pinjaman->status_pengajuan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center px-6 py-4 text-gray-500">Belum ada riwayat pinjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>