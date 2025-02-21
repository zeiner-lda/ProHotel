<?php

use App\Models\Guest;
use App\Models\Room;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('reservation_date')->nullable();
            $table->date('antecipated_reservation_date')->nullable();
            $table->time('reservation_hour');
            $table->foreignIdFor(Room::class);
            $table->foreignIdFor(Guest::class)->nullable();
            $table->foreign('hotel_id')->references('id')->on('companies');
            $table->enum('reservation_status',["pending", "confirmed", "expired"])->default('pending');           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
