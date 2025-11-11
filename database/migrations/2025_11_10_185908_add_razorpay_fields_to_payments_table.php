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
        Schema::table('payments', function (Blueprint $table) {
            // Add room_id foreign key
            $table->foreignId('room_id')->nullable()->after('user_id')->constrained('rooms', 'room_id')->onDelete('cascade');
            
            // Razorpay IDs
            $table->string('razorpay_order_id')->nullable()->after('transaction_id');
            $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            $table->string('razorpay_signature')->nullable()->after('razorpay_payment_id');
            
            // Additional payment fields
            $table->string('currency', 3)->default('INR')->after('amount');
            $table->string('payment_method_details')->nullable()->after('payment_method');
            $table->text('description')->nullable()->after('payment_method_details');
            $table->text('notes')->nullable()->after('description');
            $table->string('receipt_number')->nullable()->after('notes');
            
            // Customer info
            $table->string('customer_name')->nullable()->after('receipt_number');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone')->nullable()->after('customer_email');
            
            // Response data
            $table->text('razorpay_response')->nullable()->after('customer_phone');
            $table->text('error_description')->nullable()->after('razorpay_response');
            
            // Additional timestamps
            $table->timestamp('paid_at')->nullable()->after('payment_date');
            $table->timestamp('refunded_at')->nullable()->after('paid_at');
            
            // Modify status enum to include new statuses
            $table->enum('status', ['created', 'pending', 'success', 'failed', 'refunded', 'cancelled'])->default('created')->change();
            
            // Indexes
            $table->index('razorpay_order_id');
            $table->index('razorpay_payment_id');
            $table->index('room_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['razorpay_order_id']);
            $table->dropIndex(['razorpay_payment_id']);
            $table->dropIndex(['room_id']);
            
            // Drop foreign key
            $table->dropForeign(['room_id']);
            
            // Drop columns
            $table->dropColumn([
                'room_id',
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'currency',
                'payment_method_details',
                'description',
                'notes',
                'receipt_number',
                'customer_name',
                'customer_email',
                'customer_phone',
                'razorpay_response',
                'error_description',
                'paid_at',
                'refunded_at',
            ]);
            
            // Restore original status enum
            $table->enum('status', ['success', 'failed', 'pending'])->default('pending')->change();
        });
    }
};
