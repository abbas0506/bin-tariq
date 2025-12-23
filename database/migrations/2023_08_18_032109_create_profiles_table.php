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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('gender')->default('F');
            $table->string('cnic')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->date('joined_at')->nullable();
            $table->string('qualification')->nullable();
            $table->unsignedMediumInteger('salary')->default(0);
            $table->string('photo')->nullable(); // photo field
            $table->boolean('status')->default(true);
            $table->unsignedTinyInteger('seniority')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
