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

<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-4xl font-bold mb-6 text-center text-blue-700">PT. Sankyu Indonesia International </h1>
        <h1 class="text-2xl font-bold mb-6 text-center text-blue-700">Login Anggota</h1>
        <form method="POST" action="">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-1 font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Login</button>
        </form>
    </div>
</body>

</html>