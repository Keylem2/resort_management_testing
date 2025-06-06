<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdToInventoryRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('inventory_requests', function (Blueprint $table) {
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('inventory_requests', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
    }
}

