<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kelola Review — Admin Panel</title>
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

      <a href="/admin/barber"
         class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
        Kelola Barber
      </a>

      <a href="/admin/galeri"
         class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">
        Kelola Galeri
      </a>

      <button 
       class="flex items-center gap-3 w-full rounded-lg px-3 py-2 bg-white/10">
       Kelola Review
       </button>
    </nav>
  </aside>

  <!-- CONTENT -->
  <main class="flex-1 p-8">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl font-semibold">Kelola Review Barber</h2>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-gray-100 text-gray-600">
          <tr>
            <th class="px-4 py-3 text-left">User</th>
            <th class="px-4 py-3 text-left">Barber</th>
            <th class="px-4 py-3 text-left">Rating</th>
            <th class="px-4 py-3 text-left">Komentar</th>
            <th class="px-4 py-3 text-left">Tanggal</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          @forelse ($reviews as $review)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 font-medium">
                {{ $review->booking->user->name ?? '-' }}
              </td>

              <td class="px-4 py-3">
                {{ $review->barber->nama ?? '-' }}
              </td>

              <td class="px-4 py-3 text-yellow-500">
                @for ($i = 1; $i <= 5; $i++)
                  {{ $i <= $review->rating ? '⭐' : '☆' }}
                @endfor
              </td>

              <td class="px-4 py-3 max-w-md">
                {{ $review->comment }}
              </td>

              <td class="px-4 py-3 text-gray-500">
                {{ $review->created_at->format('d M Y') }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center py-10 text-gray-500">
                Belum ada review.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </main>
</div>
</body>
</html>
