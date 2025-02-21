<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_clients', function (Blueprint $table) {
            $table->id();
            $table->string('order_name');
            $table->float('order_price');
            $table->integer('order_room');         
            $table->integer("order_quantity");             
            $table->string("order_photo");            
            $table->double('order_status')->nullable();                        
            $table->double('status')->default(false);                        
            $table->foreignId('user_id')->constrait()->onDelete("CASCADE");
            $table->foreignId('item_id')->constrait()->onDelete("CASCADE");
            $table->foreignId('hotel_id')->constrait()->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_clients');
    }
};
