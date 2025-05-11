<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Create bookings table with all necessary columns and constraints
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('guests');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending');
            $table->integer('nights'); // Add the 'nights' column
            $table->timestamps();

            // Add index for performance improvement on check_in and check_out
            $table->index(['check_in', 'check_out']);
        });

        // Ensure correct foreign keys are set
        Schema::table('bookings', function (Blueprint $table) {
            $foreignKeys = collect(DB::select("SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'bookings' AND CONSTRAINT_TYPE = 'FOREIGN KEY'"))
                ->pluck('CONSTRAINT_NAME');
            
            if (!$foreignKeys->contains('bookings_user_id_foreign')) {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
            
            if (!$foreignKeys->contains('bookings_room_id_foreign')) {
                $table->foreign('room_id')
                    ->references('id')
                    ->on('rooms')
                    ->onDelete('cascade');
            }

            // Add index if it doesn't exist for check_in/check_out
            $indexes = collect(DB::select("SHOW INDEX FROM bookings WHERE Key_name = 'bookings_check_in_check_out_index'"));
            
            if ($indexes->isEmpty()) {
                $table->index(['check_in', 'check_out'], 'bookings_check_in_check_out_index');
            }
        });
    }

    public function down()
    {
        // Drop the table when rolling back the migration
        Schema::dropIfExists('bookings');
    }
};
