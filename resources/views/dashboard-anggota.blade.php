<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <h1 class="text-2xl font-bold mb-6">Dashboard Anggota</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
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

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="mt-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
            Logout
        </button>
    </form>

</body>

</html>
