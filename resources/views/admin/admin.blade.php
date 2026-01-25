<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Panel — Barbershop</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    ::-webkit-scrollbar { width: 10px; }
    ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 999px; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-700">
  <div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white min-h-screen p-6">
      <h1 class="text-2xl font-semibold mb-1">Admin Panel</h1>
      <p class="text-sm text-slate-300 mb-8">Barbershop Management</p>

      <nav class="space-y-2">
        <button class="flex items-center gap-3 w-full rounded-lg px-3 py-2 bg-white/10">Dashboard</button>
        <a href="/admin/layanan" class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">Kelola Layanan</a>
        <a href="/admin/barber" class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">Kelola Barber</a>
        <a href="/admin/galeri" class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">Kelola Galeri</a>
        <a href="/admin/reviews" class="flex items-center gap-3 w-full rounded-lg px-3 py-2 hover:bg-white/10">Kelola Review</a>
        <form method="POST" action="{{ route('logout') }}"
      onsubmit="return confirm('Yakin ingin logout?')">
  @csrf
  <button
    type="submit"
    class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg"
  >
  Logout
  </button>
</form>


      </nav>
      </nav>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold">Dashboard</h2>
        <div class="text-sm text-gray-500">Selamat datang, Admin</div>
      </div>

      <!-- Summary cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-6">
          <div class="text-sm text-slate-400">Total Order</div>
          <div class="mt-4 text-2xl font-bold">{{ $totalOrder ?? 0 }}</div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
          <div class="text-sm text-slate-400">Total Pemasukan</div>
          <div class="mt-4 text-2xl font-bold">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
          <div class="text-sm text-slate-400">Total Reservasi</div>
          <div class="mt-4 text-2xl font-bold">{{ $totalReservasi ?? 0 }}</div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
          <div class="text-sm text-slate-400">Order Pending</div>
          <div class="mt-4 text-2xl font-bold">{{ $pending ?? 0 }}</div>
        </div>
      </div>

      <!-- Orders table -->
      <div class="bg-white rounded-2xl shadow-sm p-6">
    <h3 class="text-lg font-semibold mb-4">Order Terbaru</h3>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="text-sm text-slate-500 border-b">
                <tr>
                    <th class="py-3 text-left">Pelanggan</th>
                    <th class="py-3 text-left">Layanan</th>
                    <th class="py-3 text-left">Tanggal & Jam</th>
                    <th class="py-3 text-left">Harga</th>
                    <th class="py-3 text-left">Bukti</th>
                    <th class="py-3 text-left">Status / Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y">
                @forelse ($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="py-4">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="py-4">{{ $order->layanan->nama ?? '-' }}</td>
                    <td class="py-4">{{ \Carbon\Carbon::parse($order->tanggal)->format('d-m-Y') }} {{ $order->jam }}</td>
                    <td class="py-4 font-semibold">Rp {{ number_format($order->layanan->harga ?? $order->harga ?? 0, 0, ',', '.') }}</td>
                    <td class="py-4">
    @if($order->bukti_pembayaran)
        <img 
            src="{{ $order->bukti_pembayaran }}" 
            width="80" 
            class="rounded-md"
            alt="Bukti Pembayaran"
        >
    @else
        <span class="text-gray-400">-</span>
    @endif
</td>

                    <td class="py-4 flex gap-2 items-center">

    @if($order->status == 'pending')
        <!-- CONFIRM -->
        <form action="{{ route('admin.bookings.confirm', $order->id) }}" method="POST">
            @csrf
            <button class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                ✅
            </button>
        </form>

        <!-- REJECT -->
        <form action="{{ route('admin.bookings.reject', $order->id) }}" method="POST">
            @csrf
            <button class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                ❌
            </button>
        </form>

    @elseif($order->status == 'confirmed')
        <span class="px-3 py-1 rounded-md bg-green-500 text-white">
            Confirmed
        </span>

    @elseif($order->status == 'cancel')
        <span class="px-3 py-1 rounded-md bg-red-500 text-white">
            Rejected
        </span>
    @endif

</td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-slate-500">Belum ada order</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <form action="{{ route('admin.bookings.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin mengosongkan semua booking?');">
    @csrf
    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
        Kosongkan Semua Booking
    </button>
</form>

</div>


    </main>
  </div>

  <script>
    // Sidebar active state
    document.querySelectorAll('aside nav a, aside nav button').forEach(el => {
      el.addEventListener('click', () => {
        document.querySelectorAll('aside nav a, aside nav button').forEach(x => x.classList.remove('bg-white/10'));
        el.classList.add('bg-white/10');
      })
    }) 
  </script>
</body>
</html>
