<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->string('payment_status')->default('pending');
            }

            if (!Schema::hasColumn('bookings', 'metode_pembayaran')) {
                $table->enum('metode_pembayaran', ['qris', 'transfer'])->default('qris');
            }

        });
    }

    public function down(): void
    {
        // intentionally empty (production-safe)
    }
};
