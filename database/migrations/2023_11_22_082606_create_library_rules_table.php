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
        Schema::create('library_rules', function (Blueprint $table) {
            $table->id();
            $table->string('user_type'); //0 for student, 1 for teacher
            $table->unsignedSmallInteger('max_books');
            $table->unsignedSmallInteger('max_days');
            $table->unsignedSmallInteger('fine_per_day')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_rules');
    }
};
