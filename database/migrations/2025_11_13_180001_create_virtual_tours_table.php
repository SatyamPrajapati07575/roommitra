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
        Schema::create('virtual_tours', function (Blueprint $table) {
            $table->id('tour_id');
            
            // Room for virtual tour
            $table->unsignedBigInteger('room_id');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
            
            // Tour details
            $table->string('tour_title');
            $table->text('tour_description')->nullable();
            $table->json('tour_images'); // Array of image URLs with descriptions
            $table->json('tour_videos')->nullable(); // Array of video URLs
            $table->json('tour_360_images')->nullable(); // 360-degree images
            
            // Tour metadata
            $table->integer('duration_minutes')->default(10); // Estimated tour duration
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);
            
            // Tour highlights
            $table->json('highlights')->nullable(); // Key features to highlight
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_tours');
    }
};
