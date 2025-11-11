<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add slug column as nullable (if not exists)
        if (!Schema::hasColumn('rooms', 'slug')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('room_title');
            });
        }
        
        // Step 2: Generate slugs for existing rooms
        $rooms = DB::table('rooms')->whereNull('slug')->orWhere('slug', '')->get();
        foreach ($rooms as $room) {
            $baseSlug = Str::slug($room->room_title);
            $slug = $baseSlug;
            $counter = 1;
            
            // Check if slug exists, if yes add counter
            while (DB::table('rooms')->where('slug', $slug)->where('room_id', '!=', $room->room_id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            DB::table('rooms')->where('room_id', $room->room_id)->update(['slug' => $slug]);
        }
        
        // Step 3: Make slug unique and not null
        DB::statement('ALTER TABLE rooms MODIFY COLUMN slug VARCHAR(255) NOT NULL');
        
        // Add unique constraint if not exists
        $indexExists = DB::select("SHOW INDEX FROM rooms WHERE Key_name = 'rooms_slug_unique'");
        if (empty($indexExists)) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->unique('slug');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
