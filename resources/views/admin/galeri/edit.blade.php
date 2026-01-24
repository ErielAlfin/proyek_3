<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto Galeri</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl p-6">

    <h2 class="text-2xl font-semibold mb-6">Edit Galeri</h2>

    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Judul</label>
            <input type="text" name="judul" value="{{ $galeri->judul }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $galeri->deskripsi }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Foto Baru (opsional)</label>
            <input type="file" name="foto" accept="image/*" class="w-full border rounded-lg px-3 py-2">
        </div>

        <!-- Foto lama -->
        <div>
            <p class="font-medium mb-1">Foto Sekarang:</p>
            <img src="{{ $galeri->foto }}" class="w-40 h-40 object-cover rounded-lg border">
        </div>

        <div class="flex justify-between pt-4">
            <a href="{{ route('admin.galeri.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-200">Kembali</a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
        </div>

    </form>

</div>

</body>
</html>
