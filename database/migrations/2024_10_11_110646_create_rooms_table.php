<?php

use App\Models\RoomDetail;
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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer("room_number");
            $table->enum("room_type",["single" , "double" , "suite"]);
            $table->integer("capacity");
            $table->integer("bed_quantity");
            $table->integer("bath_quantity");
            $table->float("price_pernight");
            $table->enum("status",["available" , "occupied"]);
            $table->longText("description");
            $table->string("photo");
            $table->foreign('hotel_id')->references('id')->on('companies');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
