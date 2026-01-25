<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            // tambah kolom metode_pembayaran kalau belum ada
            if (!Schema::hasColumn('bookings', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->after('status');
            }

            // tambah kolom bukti_pembayaran kalau belum ada
            if (!Schema::hasColumn('bookings', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('metode_pembayaran');
            }

        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'bukti_pembayaran']);
        });
    }
};
