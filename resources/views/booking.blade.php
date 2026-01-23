<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Barber</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.85)),
                  url('{{ asset('images/barber-bg.jpg') }}') no-repeat center center/cover;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .booking-form {
      background-color: rgba(20, 20, 20, 0.9);
      padding: 30px 40px;
      border-radius: 20px;
      width: 400px;
      box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
      text-align: center;
    }

    h1 {
      color: #d4af37;
      margin-bottom: 25px;
    }

    label {
      display: block;
      text-align: left;
      margin-bottom: 6px;
      font-weight: 600;
    }

    input, select {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 10px;
      margin-bottom: 15px;
      background: #222;
      color: #fff;
    }

    button {
      background: #d4af37;
      border: none;
      color: #111;
      font-weight: 700;
      padding: 12px 25px;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
      width: 100%;
    }

    button:hover {
      background: #fff;
      color: #000;
    }
  </style>
</head>
<body>
  <form class="booking-form" action="{{ route('booking.store') }}" method="POST">
    @csrf
    <h1>Form Booking Barber</h1>

    <label>Nama Lengkap</label>
    <input type="text" name="nama" required>

    <label>Pilih Barber</label>
<select name="barber_id" required>
    <option value="">-- Pilih Barber --</option>
    @foreach(\App\Models\Barber::all() as $barber)
        <option value="{{ $barber->id }}">{{ $barber->nama }}</option>
    @endforeach
</select>

    <label>Layanan</label>
<select name="layanan_id" id="layanan" required>
    <option value="">-- Pilih Layanan --</option>
    @foreach(\App\Models\Layanan::all() as $layanan)
        <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}">
            {{ $layanan->nama }} (Rp{{ number_format($layanan->harga,0,',','.') }})
        </option>
    @endforeach
</select>


    <label>Tanggal</label>
<input type="date" name="tanggal" required>

<label>Jam</label>
<input type="time" name="jam" required>


    <!-- hidden input harga -->
    <input type="hidden" name="harga" id="harga">
<label>Total Pembayaran</label>
<input type="text" id="total_display" readonly>

    <button type="submit">Booking Sekarang</button>
    
</form>

<script>
const layananSelect = document.getElementById('layanan');
const hargaInput = document.getElementById('harga');
const totalDisplay = document.getElementById('total_display');

layananSelect.addEventListener('change', () => {
    const option = layananSelect.selectedOptions[0];
    const harga = option ? option.dataset.harga : 0;

    hargaInput.value = harga;
    totalDisplay.value = 'Rp ' + Number(harga).toLocaleString('id-ID');
});
</script>


</body>
</html>
