@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white rounded shadow mt-10">
    <h1 class="text-xl font-bold mb-4">Upload Bukti Pembayaran</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('booking.payment.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Bukti Transfer</label>
            <input type="file" name="bukti_transfer" class="border p-2 w-full" required>
            @error('bukti_transfer')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Kirim Bukti Pembayaran
        </button>
    </form>
</div>
@endsection
