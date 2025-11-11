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
        Schema::create('amenities_master', function (Blueprint $table) {
            $table->id('amenity_id');
            $table->string('amenity_name', 100);
            $table->string('amenity_key', 50)->unique();
            $table->string('icon_class', 100)->nullable(); // BoxIcon class
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Insert default amenities
        DB::table('amenities_master')->insert([
            ['amenity_name' => 'Air Conditioning', 'amenity_key' => 'ac', 'icon_class' => 'bx-wind', 'display_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Lift/Elevator', 'amenity_key' => 'lift', 'icon_class' => 'bx-up-arrow-circle', 'display_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Parking', 'amenity_key' => 'parking', 'icon_class' => 'bx-car', 'display_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Ceiling Fan', 'amenity_key' => 'amenity_fan', 'icon_class' => 'bx-wind', 'display_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Bed', 'amenity_key' => 'amenity_bed', 'icon_class' => 'bx-bed', 'display_order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Study Table', 'amenity_key' => 'amenity_table', 'icon_class' => 'bx-table', 'display_order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Chair', 'amenity_key' => 'amenity_chair', 'icon_class' => 'bx-chair', 'display_order' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Wardrobe/Cupboard', 'amenity_key' => 'amenity_wardrobe', 'icon_class' => 'bx-cabinet', 'display_order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'WiFi', 'amenity_key' => 'amenity_wifi', 'icon_class' => 'bx-wifi', 'display_order' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Geyser/Hot Water', 'amenity_key' => 'amenity_geyser', 'icon_class' => 'bx-water', 'display_order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Television', 'amenity_key' => 'amenity_tv', 'icon_class' => 'bx-tv', 'display_order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['amenity_name' => 'Refrigerator', 'amenity_key' => 'amenity_fridge', 'icon_class' => 'bx-fridge', 'display_order' => 12, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities_master');
    }
};
