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
        Schema::create('book_issuances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedSmallInteger('copy_no');
            $table->unsignedBigInteger('user_id');
            $table->string('user_type', 30);
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->boolean('book_status')->default(1);

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_issuances');
    }
};
