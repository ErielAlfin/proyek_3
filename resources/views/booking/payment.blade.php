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
                url('{{ asset('images/barber-bg.jpg') }}') no-repeat center center/cover;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}
.payment-card {
    background: rgba(20,20,20,0.95);
    padding: 30px 40px;
    border-radius: 20px;
    width: 400px;
    box-shadow: 0 0 20px rgba(212,175,55,0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
h2, h3 { color: #d4af37; margin-bottom: 15px; }
p { margin: 6px 0; }
hr { border: 0; border-top: 1px solid #444; width: 100%; margin: 15px 0; }
.qris-section { margin: 20px 0; }
.qris-section img { width: 250px; border-radius: 10px; box-shadow: 0 0 15px rgba(212,175,55,0.5); }
form { display: flex; flex-direction: column; gap: 15px; width: 100%; }
input[type="file"] { padding: 8px; border-radius: 10px; border: none; background: #222; color: #fff; }
button { background: #d4af37; border: none; color: #111; font-weight: 700; padding: 12px; border-radius: 10px; cursor: pointer; transition: 0.3s; }
button:hover { background: #fff; color: #000; }
.note { font-size: 0.85em; color: #ccc; }
.status-text { font-size: 0.9em; color: #d4af37; text-align: center; margin-top: 10px; }
.status-error { font-size: 0.85em; color: #ff6666; text-align: center; margin-top: 10px; }
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

    <h3>Total Pembayaran</h3>
    <p><strong>Rp{{ number_format($booking->harga,0,',','.') }}</strong></p>

    <hr>

    <div class="qris-section">
        <p>Silakan scan QRIS berikut untuk melakukan pembayaran:</p>
        <img src="{{ asset('images/qris.png') }}" alt="QRIS Pembayaran">
        <p class="note">* Setelah melakukan pembayaran, upload bukti transfer.</p>
    </div>

    <form id="uploadForm">
        @csrf
        <label>Upload Bukti Pembayaran</label>
        <input type="file" id="bukti_transfer" accept="image/*" required>
        <input type="hidden" name="bukti_transfer_url" id="bukti_transfer_url">
        <button type="submit" id="submitBtn">Kirim Bukti Pembayaran</button>
    </form>

    <div id="status" class="status-text"></div>
    <div id="statusError" class="status-error"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.6/axios.min.js"></script>
<script>
document.getElementById('uploadForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const fileInput = document.getElementById('bukti_transfer');
    const file = fileInput.files[0];
    const status = document.getElementById('status');
    const statusError = document.getElementById('statusError');
    const submitBtn = document.getElementById('submitBtn');

    statusError.innerText = '';
    status.innerText = '';

    if(!file){
        alert('Pilih file terlebih dahulu!');
        return;
    }

    submitBtn.disabled = true;
    status.innerText = 'Mengunggah ke Cloudinary...';

    const formData = new FormData();
    formData.append('file', file);
    formData.append('upload_preset', 'booking_unsigned'); // <-- ganti preset unsigned kamu

    try {
        const cloudName = 'drlg2oapt'; // <-- ganti cloud name kamu
        const url = `https://api.cloudinary.com/v1_1/${cloudName}/upload`;

        const response = await axios.post(url, formData);
        const secure_url = response.data.secure_url;

        document.getElementById('bukti_transfer_url').value = secure_url;
        status.innerText = 'Upload sukses! Mengirim ke server...';

        // Kirim ke Laravel
        const laravelForm = new FormData();
        laravelForm.append('_token', '{{ csrf_token() }}');
        laravelForm.append('bukti_transfer_url', secure_url);

        const laravelResponse = await axios.post('{{ route('booking.payment.upload', $booking->id) }}', laravelForm);

        if(laravelResponse.data.success){
            status.innerText = 'Bukti pembayaran berhasil dikirim! Redirect ke profil...';
            setTimeout(() => {
                window.location.href = '{{ route('profil.index') }}';
            }, 1000);
        } else {
            statusError.innerText = 'Server menolak data. Periksa log Laravel.';
            submitBtn.disabled = false;
        }

    } catch(err){
        console.error('Error detail:', err.response ? err.response.data : err);
        statusError.innerText = 'Gagal upload! Lihat console untuk detail.';
        submitBtn.disabled = false;
    }
});
</script>

</body>
</html>
