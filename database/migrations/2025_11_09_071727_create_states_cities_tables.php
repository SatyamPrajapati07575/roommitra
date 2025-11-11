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
        // States Table
        Schema::create('states', function (Blueprint $table) {
            $table->id('state_id');
            $table->string('state_name', 100);
            $table->string('state_code', 10)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Cities Table
        Schema::create('cities', function (Blueprint $table) {
            $table->id('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('city_name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('state_id')->references('state_id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
    }
};
