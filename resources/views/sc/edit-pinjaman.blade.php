<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pinjaman</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Pinjaman</h1>

        <!-- Form Edit Pinjaman -->
        <form action="{{ route('sc.update-pinjaman', $pinjaman->id) }}" method="POST">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="mb-4">
                <label for="jumlah_pinjaman" class="block text-sm font-semibold">Jumlah Pinjaman</label>
                <input type="number" name="jumlah_pinjaman" id="jumlah_pinjaman"
                    class="w-full px-4 py-2 border rounded-lg" value="{{ $pinjaman->jumlah_pinjaman }}" required>
            </div>

            <div class="mb-4">
                <label for="jangka_waktu" class="block text-sm font-semibold">Jangka Waktu (bulan)</label>
                <input type="number" name="jangka_waktu" id="jangka_waktu"
                    class="w-full px-4 py-2 border rounded-lg" value="{{ $pinjaman->jangka_waktu }}" required>
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Update</button>
        </form>
    </div>

</body>

</html>