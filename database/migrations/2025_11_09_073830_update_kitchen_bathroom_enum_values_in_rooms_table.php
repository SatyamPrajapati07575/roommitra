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
        // Step 1: Convert enum to varchar temporarily
        DB::statement("ALTER TABLE rooms MODIFY COLUMN kitchen_type VARCHAR(20) NULL");
        DB::statement("ALTER TABLE rooms MODIFY COLUMN bathroom_type VARCHAR(20) NOT NULL");
        
        // Step 2: Update existing data to match new enum values
        DB::statement("UPDATE rooms SET kitchen_type = 'private' WHERE kitchen_type = 'personal'");
        DB::statement("UPDATE rooms SET bathroom_type = 'common' WHERE bathroom_type = 'shared'");
        
        // Step 3: Convert back to enum with new values
        DB::statement("ALTER TABLE rooms MODIFY COLUMN kitchen_type ENUM('private', 'shared', 'none') NULL");
        DB::statement("ALTER TABLE rooms MODIFY COLUMN bathroom_type ENUM('attached', 'common') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert data
        DB::statement("UPDATE rooms SET kitchen_type = 'personal' WHERE kitchen_type = 'private'");
        DB::statement("UPDATE rooms SET bathroom_type = 'shared' WHERE bathroom_type = 'common'");
        
        // Revert enum values
        DB::statement("ALTER TABLE rooms MODIFY COLUMN kitchen_type ENUM('personal', 'shared') NULL");
        DB::statement("ALTER TABLE rooms MODIFY COLUMN bathroom_type ENUM('attached', 'shared') NOT NULL");
    }
};
