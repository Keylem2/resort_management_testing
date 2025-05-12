<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRejectionFieldsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['rejected_by']);
            
            // Then drop the columns
            $table->dropColumn('rejection_reason');
            $table->dropColumn('rejected_by');
            $table->dropColumn('rejected_at');
        });
    }
}

