<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('booking_inventory')) {
            Schema::create('booking_inventory', function (Blueprint $table) {
                $table->engine = 'InnoDB'; // Ensure the InnoDB engine is used

                $table->id();
                
                // Use unsignedBigInteger for foreign keys
                $table->unsignedBigInteger('booking_id');
                $table->unsignedBigInteger('inventory_id');
                
                // Define the foreign keys
                $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
                $table->foreign('inventory_id')->references('id')->on('inventory')->onDelete('cascade');
                
                $table->integer('quantity_used')->default(1);
                $table->boolean('replaced')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('booking_inventory');
    }
};
