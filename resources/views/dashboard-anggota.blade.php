<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Anggota - Koperasi PT. Sankyu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS / App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans text-gray-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md hidden md:block">
            <div class="p-6 text-blue-800 font-bold text-xl">
                Koperasi Sankyu
            </div>
            <nav class="px-4 space-y-2">
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Simpanan</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Pinjaman</a>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Dashboard Anggota</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-100 p-6 rounded-lg shadow text-center">
                    <div class="text-lg font-semibold text-blue-700 mb-2">Total Simpanan</div>
                    <div class="text-3xl font-bold text-blue-900">
                        Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="bg-red-100 p-6 rounded-lg shadow text-center">
                    <div class="text-lg font-semibold text-red-700 mb-2">Total Pinjaman</div>
                    <div class="text-3xl font-bold text-red-900">
                        Rp {{ number_format($totalPinjaman ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                <div class="bg-green-100 p-6 rounded-lg shadow text-center">
                    <div class="text-lg font-semibold text-green-700 mb-2">Cicilan Perbulan</div>
                    <div class="text-3xl font-bold text-green-900">
                        Rp {{ number_format($cicilanPerbulan ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Riwayat Simpanan -->
            <div id="section-simpanan" class="bg-white shadow rounded-lg mb-6">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold text-blue-800">Riwayat Simpanan</h2>
                    <button onclick="printSection('section-simpanan')" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                        Cetak Simpanan
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Tanggal</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Jenis</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($riwayatSimpanan as $s)
                            <tr>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($s->tanggal_simpanan)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 capitalize">{{ $s->jenis_simpanan }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($s->jumlah_simpanan, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data simpanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Riwayat Pinjaman -->
            <div id="section-pinjaman" class="bg-white shadow rounded-lg mb-6">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold text-red-800">Riwayat Pinjaman</h2>
                    <button onclick="printSection('section-pinjaman')" class="text-sm bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                        Cetak Pinjaman
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Tanggal</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Jumlah</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Cicilan</th>
                                <th class="px-6 py-3 text-left text-gray-500 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($riwayatPinjaman as $p)
                            <tr>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($p->tanggal_pinjaman)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($p->cicilan, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 capitalize">{{ $p->status_pinjaman }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data pinjaman.</td>
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
            location.reload(); // refresh ulang agar kembali normal
        }
    </script>

</body>

</html>