<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barber</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-2xl mx-auto bg-white shadow p-6 rounded-xl">

        <h2 class="text-xl font-semibold mb-6">Edit Barber</h2>

        <form action="{{ route('admin.barber.update', $barber->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label class="block mb-1 font-medium">Nama Barber</label>
                <input type="text" name="nama" value="{{ $barber->nama }}" class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <!-- Spesialis -->
            <div>
                <label class="block mb-1 font-medium">Spesialis</label>
                <input type="text" name="spesialis" value="{{ $barber->spesialis }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Telepon -->
            <div>
                <label class="block mb-1 font-medium">Telepon</label>
                <input type="text" name="telepon" value="{{ $barber->telepon }}" class="w-full border rounded-lg px-3 py-2">
            </div>

            <!-- Foto Lama -->
            <div>
                <label class="block mb-1 font-medium">Foto Sekarang</label>
                <img src="{{ asset('storage/barbers/' . $barber->foto) }}" class="w-32 h-32 object-cover rounded-lg mb-3">
            </div>

            <!-- Foto Baru -->
            <div>
                <label class="block mb-1 font-medium">Ganti Foto (opsional)</label>
                <input type="file" name="foto" accept="image/*">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.barber.index') }}" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update
                </button>
            </div>

        </form>
    </div>

</body>
</html>
