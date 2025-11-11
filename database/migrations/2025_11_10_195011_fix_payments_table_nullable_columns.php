<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix nullable columns for Razorpay payment integration
        DB::statement("ALTER TABLE payments MODIFY booking_id BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE payments MODIFY transaction_id VARCHAR(255) NULL");
        DB::statement("ALTER TABLE payments MODIFY payment_method VARCHAR(50) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes
        DB::statement("ALTER TABLE payments MODIFY booking_id BIGINT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE payments MODIFY transaction_id VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE payments MODIFY payment_method ENUM('UPI','Credit Card','Debit Card','Net Banking') NOT NULL");
    }
};
