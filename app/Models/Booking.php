<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Barber;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'barber_id',
    'layanan_id',
    'tanggal',
    'jam',
    'durasi',
    'end_time', // wajib
    'harga',
    'status',
    'metode_pembayaran',
    'bukti_pembayaran',
];




    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    // Relasi ke barber
    public function barber()
    {
        return $this->belongsTo(Barber::class, 'barber_id');
    }
}
