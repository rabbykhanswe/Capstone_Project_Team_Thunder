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
        Schema::table('plants', function (Blueprint $table) {
            $table->text('care_instructions')->nullable();
            $table->string('sunlight_requirements')->nullable();
            $table->string('water_requirements')->nullable();
            $table->string('environment')->default('indoor'); // indoor, outdoor, both
            $table->string('plant_type')->default('plant'); // plant, succulent, tool, etc.
            $table->json('image_gallery')->nullable(); // Store multiple image URLs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plants', function (Blueprint $table) {
            $table->dropColumn([
                'care_instructions',
                'sunlight_requirements', 
                'water_requirements',
                'environment',
                'plant_type',
                'image_gallery'
            ]);
        });
    }
};
