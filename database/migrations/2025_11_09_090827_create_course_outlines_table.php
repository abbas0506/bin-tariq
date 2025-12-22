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
        Schema::create('course_outlines', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('day_no');
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('grade');
            $table->string('topic', 200);
            $table->string('activity', 200)->nullable();
            $table->string('assignment', 200)->nullable();
            $table->string('media_url', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_outlines');
    }
};
