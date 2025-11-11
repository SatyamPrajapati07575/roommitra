<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Payment frequency: full or monthly
            $table->enum('payment_frequency', ['full', 'monthly'])->default('full')->after('payment_method');
            
            // Payment type: online or offline
            $table->enum('payment_type', ['online', 'offline'])->default('online')->after('payment_frequency');
            
            // Monthly installment amount (if payment_frequency is monthly)
            $table->decimal('monthly_amount', 10, 2)->nullable()->after('payment_type');
            
            // Number of months
            $table->integer('duration_months')->default(1)->after('monthly_amount');
            
            // Occupancy
            $table->integer('occupancy')->default(1)->after('duration_months');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_frequency', 'payment_type', 'monthly_amount', 'duration_months', 'occupancy']);
        });
    }
};
