<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Layanan</h2>

        <form action="{{ route('admin.layanan.store') }}" method="POST">
            @csrf

            <label class="block mb-2">Nama Layanan</label>
            <input type="text" name="nama" class="w-full border rounded-lg p-2 mb-4" required>

            <label class="block mb-2">Deskripsi</label>
            <textarea name="deskripsi" class="w-full border rounded-lg p-2 mb-4"></textarea>

            <label class="block mb-2">Harga</label>
            <input type="number" name="harga" class="w-full border rounded-lg p-2 mb-4" required>

            <label class="block mb-2">Durasi (menit)</label>
            <input type="number" name="durasi" class="w-full border rounded-lg p-2 mb-4" required>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
        </form>

        <a href="{{ route('admin.layanan.index') }}" class="text-blue-600 block mt-4">← Kembali</a>
    </div>

</body>
</html>
