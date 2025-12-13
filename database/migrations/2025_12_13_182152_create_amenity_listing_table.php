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
    Schema::create('amenity_listing', function (Blueprint $table) {
        $table->id();
        $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
        $table->foreignId('listing_id')->constrained()->cascadeOnDelete();

        $table->unique(['amenity_id', 'listing_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenity_listing');
    }
};
