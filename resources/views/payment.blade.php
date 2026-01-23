<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.85)),
                        url('{{ asset('images/barber-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .payment-card {
            background: rgba(20, 20, 20, 0.95);
            padding: 30px 40px;
            border-radius: 20px;
            width: 400px;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        }

        h2 {
            color: #d4af37;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 6px 0;
        }

        hr {
            border: 0;
            border-top: 1px solid #444;
            margin: 15px 0;
        }

        .qris-section {
            text-align: center;
            margin: 20px 0;
        }

        .qris-section img {
            width: 250px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: 600;
        }

        input[type="file"] {
            padding: 5px;
            border-radius: 10px;
            border: none;
            background: #222;
            color: #fff;
        }

        button {
            background: #d4af37;
            border: none;
            color: #111;
            font-weight: 700;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #fff;
            color: #000;
        }

        .note {
            font-size: 0.85em;
            color: #ccc;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="payment-card">
    <h2>Pembayaran Booking</h2>

    <p><strong>Tanggal:</strong> {{ $booking->tanggal }}</p>
    <p><strong>Jam:</strong> {{ $booking->jam }}</p>
    <p><strong>Barber:</strong> {{ $booking->barber->nama }}</p>
    <p><strong>Layanan:</strong> {{ $booking->layanan->nama }}</p>

    <hr>

    <p><strong>Total Pembayaran:</strong> Rp{{ number_format($booking->harga,0,',','.') }}</p>

    <hr>

    <div class="qris-section">
        <p>Silakan scan QRIS berikut untuk melakukan pembayaran:</p>
        <img src="{{ asset('images/qris.png') }}" alt="QRIS Pembayaran">
        <p class="note">* Setelah melakukan pembayaran, simpan bukti transfer.</p>
    </div>

    <form action="{{ route('booking.payment.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Upload Bukti Pembayaran</label>
        <input type="file" name="bukti_transfer" required>
        <button type="submit">Kirim Bukti</button>
    </form>
</div>

</body>
</html>
