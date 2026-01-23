<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Galeri — Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-700">
  <div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white min-h-screen p-6">
      <div class="mb-8">
        <h1 class="text-2xl font-semibold">Admin Panel</h1>
        <p class="text-sm text-slate-300">Barbershop Management</p>
      </div>

      <nav class="space-y-2">
       <a href="/admin" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Dashboard
       </a>
       <a href="/admin/layanan" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Kelola Layanan
       </a>
       <a href="/admin/barber" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Kelola Barber
       </a>
       <button 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 bg-white/10">
       Kelola Galeri
       </button>
       <a href="/admin/reviews" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Kelola Review
       </a>
       </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">

      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold">Kelola Galeri</h2>
        <a href="{{ route('admin.galeri.create') }}" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
          <span>+</span> Tambah Foto
        </a>
      </div>

      <!-- Grid Galeri -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach ($galeri as $item)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3">
          <img src="{{ asset('storage/' . $item->foto) }}" class="rounded-xl h-40 w-full object-cover mb-3" />

          <div class="flex justify-between items-start mb-1">
            <h3 class="font-semibold text-base">{{ $item->judul }}</h3>
            <div class="flex gap-3 text-gray-500">
              <a href="{{ route('admin.galeri.edit', $item->id) }}">✎</a>
              <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button>🗑</button>
              </form>
            </div>
          </div>

          <p class="text-sm text-gray-500">{{ $item->deskripsi }}</p>
        </div>
        @endforeach

      </div>

    </main>
  </div>
</body>
</html>
