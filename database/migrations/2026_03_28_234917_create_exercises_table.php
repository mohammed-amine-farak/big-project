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
        Schema::create('exercises', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('lesson_id');
           $table->enum('difficulty', ['easy','medium','hard'])->default('easy');
           $table->text('question');
           $table->enum('type', ['multiple_choice'])->default('multiple_choice');
           $table->integer('points')->default(10);
           $table->integer('order')->default(0);
           $table->foreign('lesson_id')->references('id')->on('lessonss')->onDelete('cascade');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
