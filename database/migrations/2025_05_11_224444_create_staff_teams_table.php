<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTeamsTable extends Migration
{
    public function up()
    {
        Schema::create('staff_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_head_id'); // Reference to the staff head (HR employee)
            $table->unsignedBigInteger('employee_id'); // Reference to the team member (Housekeeper or Lifeguard)
            $table->string('role'); // Role within the team (e.g., Housekeeper, Lifeguard)
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('staff_head_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff_teams');
    }
}