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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('photo', 50)->nullable();
            $table->string('name', 50);
            $table->string('bform', 15);
            $table->string('gender', 1)->default('m');
            $table->string('phone', 16);
            $table->string('address', 100)->nullable();
            $table->date('dob');
            $table->string('id_mark', 100);
            $table->string('caste', 50);

            $table->boolean('is_orphan')->default(false);
            $table->string('father_name', 50)->nullable();
            $table->string('mother_name', 50)->nullable();
            $table->string('father_cnic')->nullable();
            $table->string('mother_cnic')->nullable();
            $table->string('profession', 50)->nullable();
            $table->unsignedInteger('income')->nullable();

            $table->unsignedSmallInteger('grade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->year('pass_year');
            $table->enum('medium', ['en', 'ur'])->default('ur'); //english:0, urdu:1
            $table->string('previous_school')->nullable();
            $table->string('bise', 20);
            $table->string('rollno', 8);
            $table->unsignedSmallInteger('obtained_marks');
            $table->unsignedSmallInteger('max_marks');
            $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected', 'admitted'
            $table->unsignedInteger('amount_paid')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->default('cash'); // 'cash', 'bank', 'online'
            $table->unsignedSmallInteger('fee_concession')->nullable();
            $table->string('rejection_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
