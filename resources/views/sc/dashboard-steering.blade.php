<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pengajuan Pinjaman</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md hidden md:block">
            <div class="p-6 text-blue-800 font-bold text-xl">
                Admin Koperasi
            </div>
            <nav class="px-4 space-y-2">
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Pengajuan Pinjaman</a>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Daftar Pengajuan Pinjaman</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Tabel Pengajuan Pinjaman -->
            <div id="section-pinjaman" class="bg-white shadow rounded-lg">
                <div class="p-4 border-b flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-red-800">Pengajuan Pinjaman</h2>
                    <button onclick="printSection('section-pinjaman')" class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                        Cetak
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Tanggal Pengajuan</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Nama Anggota</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Jumlah Pinjaman</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Cicilan</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Status Pengajuan</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Aksi</th
                                    </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pengajuanPinjaman as $p)
                            <tr>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">{{ $p->member->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($p->cicilan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 capitalize">{{ $p->status_pengajuan }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <form method="POST" action="{{ route('pinjaman.diterima', $p->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                            Setujui
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('pinjaman.ditolak', $p->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada pengajuan pinjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        function printSection(id) {
            const section = document.getElementById(id).innerHTML;
            const original = document.body.innerHTML;
            document.body.innerHTML = section;
            window.print();
            document.body.innerHTML = original;
            location.reload();
        }
    </script>
</body>

</html>