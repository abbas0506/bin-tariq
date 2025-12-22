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
            $table->string('photo', 50)->nullable();
            $table->string('name', 50);
            $table->string('bform', 15);
            $table->string('gender', 1)->default('m');
            $table->string('phone', 16)->nullable();
            $table->string('address', 100)->nullable();
            $table->date('dob')->nullable();
            $table->string('id_mark', 100)->nullable();
            $table->string('caste', 50)->nullable();
            $table->string('distinction')->nullable();
            $table->boolean('is_orphan')->default(false);
            $table->string('father_name', 50)->nullable();
            $table->string('father_cnic')->nullable();
            $table->string('profession', 50)->nullable();
            $table->string('blood_grou', 5)->nullable();
            $table->unsignedInteger('income')->nullable();


            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('rollno');
            $table->date('admission_date')->nullable();
            $table->string('admission_no')->nullable()->unique();
            $table->string('score')->nullable(); //for indexing

            $table->boolean('library_banned')->default(0);
            $table->boolean('card_printed')->default(0);

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
