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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('short_name');
            $table->string('father_name')->nullable();
            $table->string('cnic')->unique();
            $table->date('dob')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->date('joined_at')->nullable();
            $table->string('designation')->nullable();
            $table->string('qualification')->nullable();
            $table->string('personal_no')->nullable();
            $table->string('bps')->nullable();
            $table->string('photo')->nullable(); // photo field
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
