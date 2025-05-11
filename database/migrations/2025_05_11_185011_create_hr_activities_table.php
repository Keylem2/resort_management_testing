<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('hr_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->string('type')->default('general'); // leave, attendance, payroll, employee
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('action_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hr_activities');
    }
}