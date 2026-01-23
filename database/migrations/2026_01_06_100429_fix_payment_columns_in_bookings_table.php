<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        // pastikan payment_status bisa terima 'waiting'
        $table->string('payment_status')->change();

        // ganti nama kolom bukti
        if (Schema::hasColumn('bookings', 'bukti_pembayaran')) {
            $table->renameColumn('bukti_pembayaran', 'bukti_transfer');
        }

        // tambah method pembayaran JIKA BELUM ADA
        if (!Schema::hasColumn('bookings', 'payment_method')) {
            $table->string('payment_method')->nullable();
        }
    });
}


public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        if (Schema::hasColumn('bookings', 'payment_method')) {
            $table->dropColumn('payment_method');
        }

        if (Schema::hasColumn('bookings', 'bukti_transfer')) {
            $table->renameColumn('bukti_transfer', 'bukti_pembayaran');
        }
    });
}


};
