<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barber</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-2xl mx-auto bg-white shadow-lg border border-gray-200 p-6 rounded-2xl">

        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Tambah Barber</h2>

        @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <form action="{{ route('admin.barber.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-5">
              
            @csrf

            <!-- Nama -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Nama Barber</label>
                <input type="text" name="nama" 
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                    required>
            </div>

            <!-- Keahlian -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Spesialis</label>
                <input type="text" name="spesialis" 
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300"
                    required>
            </div>

            <!-- Telepon -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Telepon</label>
                <input type="text" name="telepon" 
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
            </div>

            <!-- Foto -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Foto Barber</label>
                <input type="file" 
                       name="foto" 
                       accept="image/*" 
                       class="w-full cursor-pointer">
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('admin.barber.index') }}" 
                   class="px-4 py-2 rounded-lg border border-gray-400 text-gray-600 hover:bg-gray-200">
                   Kembali
                </a>

                <button type="submit" 
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</body>
</html>
