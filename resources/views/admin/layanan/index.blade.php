<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kelola Layanan — Barbershop</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-700">
  <div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white min-h-screen p-6">
      <h1 class="text-2xl font-semibold mb-1">Admin Panel</h1>
      <p class="text-sm text-slate-300 mb-8">Barbershop Management</p>

      <nav class="space-y-2">
       <a href="/admin" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Dashboard
       </a>
       </a>
       <button 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 bg-white/10">
       Kelola Layanan
       </button>
       <a href="/admin/barber" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Kelola Barber
       </a>
       <a href="/admin/galeri" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Kelola Galeri
       </a>
       <a href="/admin/reviews" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Kelola Review
       </a>
       </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8">

      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold">Kelola Layanan</h2>
        <a href="{{ route('admin.layanan.create') }}" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
          <span>+</span> Tambah Layanan
        </a>
      </div>

      <!-- Grid Layanan -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        @foreach ($layanan as $item)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
          <div class="flex justify-between items-start mb-2">
            <h3 class="font-semibold text-lg">{{ $item->nama }}</h3>
            <div class="flex gap-3 text-gray-500">
              <a href="{{ route('admin.layanan.edit', $item->id) }}">✎</a>
              <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                @csrf
                @method('DELETE')
                <button>🗑</button>
              </form>
            </div>
          </div>

          <p class="text-sm text-gray-500 mb-4">{{ $item->deskripsi }}</p>

          <p class="text-xs text-gray-400">Harga</p>
          <p class="text-blue-600 font-semibold mb-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>

          <div class="flex items-center text-sm text-gray-500 gap-2">⏱ {{ $item->durasi }} menit</div>
        </div>
        @endforeach

      </div>

    </main>
  </div>
</body>
</html>