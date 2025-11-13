<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id('visit_id');
            
            // User who wants to visit
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            // Room to visit
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
            
            // Visit details
            $table->enum('visit_type', ['physical', 'virtual'])->default('physical');
            $table->date('preferred_date');
            $table->time('preferred_time');
            $table->date('alternative_date')->nullable();
            $table->time('alternative_time')->nullable();
            
            // Contact details
            $table->string('visitor_name');
            $table->string('visitor_phone');
            $table->string('visitor_email');
            $table->text('special_requirements')->nullable();
            
            // Visit status
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'rescheduled'])->default('pending');
            $table->date('confirmed_date')->nullable();
            $table->time('confirmed_time')->nullable();
            
            // Owner response
            $table->text('owner_notes')->nullable();
            $table->timestamp('owner_responded_at')->nullable();
            
            // Virtual tour details (if applicable)
            $table->string('meeting_link')->nullable();
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
