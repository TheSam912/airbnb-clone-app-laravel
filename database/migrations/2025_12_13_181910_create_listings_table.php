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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // host

            $table->string('title');
            $table->text('description');

            // Address (one per listing)
            $table->string('country', 2); // ISO-3166 alpha2 (e.g. GB)
            $table->string('city');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('postcode')->nullable();

            // For map/search later
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            // Capacity
            $table->unsignedTinyInteger('max_guests');
            $table->unsignedTinyInteger('bedrooms')->default(1);
            $table->unsignedTinyInteger('beds')->default(1);
            $table->unsignedTinyInteger('bathrooms')->default(1);

            // Pricing
            $table->unsignedInteger('price_per_night'); // store in cents
            $table->string('currency', 3)->default('USD');

            // Status
            $table->boolean('is_published')->default(false);

            $table->timestamps();

            $table->index(['city']);
            $table->index(['is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
