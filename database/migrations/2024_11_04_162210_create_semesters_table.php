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
        Schema::create('semesters', function (Blueprint $table) {
            // represent a semester with
            // semester number, eg I
            // semester start year, eg 2023
            // semeter end yer, eg 2024
            // so the example will represent SEM I 2023/2024
            $table->id();
            $table->unsignedSmallInteger("semester_number");
            $table->unsignedSmallInteger("start_year");
            $table->unsignedSmallInteger("end_year");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
