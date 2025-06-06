<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->unsignedBigInteger('approved_by')->nullable();
        $table->timestamp('approved_at')->nullable();
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['approved_by', 'approved_at']);
    });
}

};
