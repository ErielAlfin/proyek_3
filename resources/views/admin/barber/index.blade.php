<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kelola Barber — Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen text-gray-700">
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
       <a href="/admin/layanan" 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
       Kelola Layanan
       </a>
       <button 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 bg-white/10">
       Kelola Barber
       </button>
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

    <!-- CONTENT -->
    <main class="flex-1 p-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold">Kelola Barber</h2>
        <a href="{{ route('admin.barber.create') }}" 
   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
   + Tambah Barber
</a>

      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse ($barbers as $barber)
        <div class="bg-white rounded-xl shadow p-4">
          <img 
  src="{{ $barber->foto ?? 'https://via.placeholder.com/300x200?text=No+Image' }}"
  class="w-full h-40 object-cover rounded-lg"
/>


          <div class="mt-4">
            <div class="flex justify-between items-start">
              <h3 class="font-semibold">{{ $barber->nama }}</h3>

              <div class="flex gap-3 text-gray-500">
                <!-- Edit -->
                <a href="{{ route('admin.barber.edit', $barber->id) }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </a>

                <!-- Delete -->
                <form action="{{ route('admin.barber.destroy', $barber->id) }}" method="POST" onsubmit="return confirm('Hapus barber ini?');">

                  @csrf
                  @method('DELETE')
                  <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                  </button>
                </form>
              </div>
            </div>

            <p class="text-sm text-gray-500 mt-1">{{ $barber->spesialis }}</p>
            <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">📞 {{ $barber->telepon }}</p>
          </div>
        </div>
        @empty
        <div class="col-span-4 text-center text-gray-500 py-10">
          Belum ada barber terdaftar.
        </div>
        @endforelse

      </div>
    </main>
  </div>
</body>
</html>
