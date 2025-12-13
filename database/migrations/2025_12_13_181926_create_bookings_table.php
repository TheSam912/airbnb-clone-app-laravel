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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // guest

            $table->date('check_in');
            $table->date('check_out');

            $table->unsignedTinyInteger('guests');
            $table->unsignedInteger('price_per_night'); // snapshot in cents
            $table->unsignedInteger('subtotal');        // nights * price_per_night

            $table->string('status')->default('pending'); // pending, confirmed, cancelled

            $table->timestamps();

            $table->index(['listing_id', 'check_in', 'check_out']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
