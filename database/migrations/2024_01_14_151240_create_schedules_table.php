<?php

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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_shift', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id')->unsigned();
            $table->integer('shift_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('employee_schedule', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('location_schedule', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('schedule_shift', function (Blueprint $table) {
            $table->dropForeign(['shift_id']);
            $table->dropForeign(['schedule_id']);
        });

        Schema::table('employee_schedule', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
            $table->dropForeign(['employee_id']);
        });

        Schema::table('location_schedule', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
            $table->dropForeign(['location_id']);
        });

        Schema::dropIfExists('schedule_shift');
        Schema::dropIfExists('employee_schedule');
        Schema::dropIfExists('location_schedule');
        Schema::dropIfExists('schedules');
    }
};
