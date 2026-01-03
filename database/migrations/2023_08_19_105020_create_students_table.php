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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('father_name', 50)->nullable();
            $table->string('bform', 15)->nullable();
            $table->string('gender', 1)->default('m');
            $table->string('phone', 16)->nullable();
            $table->string('address', 100)->nullable();
            $table->date('dob')->nullable();
            $table->string('photo', 50)->nullable();

            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->string('rollno');
            $table->date('admission_date')->nullable();
            $table->string('admission_no')->nullable()->unique();
            $table->boolean('status')->default(true);   //active or not
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
