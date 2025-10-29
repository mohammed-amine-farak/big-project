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
        Schema::create('student_lesson_progresses', function (Blueprint $table) {
            $table->id(); // Primary key for the progress entry

            // Define the columns before setting them as foreign keys
            $table->unsignedBigInteger('lesson_id'); // Column to hold the lesson ID
            $table->unsignedBigInteger('student_id'); // Column to hold the student ID

            $table->integer('completion_percentage')->default(0); // "نسبة الإنجاز"
            $table->text('subject')->nullable(); // If you want to store the subject here

            // Foreign key constraints using your specified method
            $table->foreign('lesson_id')->references('id')->on('lessonss')->onDelete('cascade'); // Corrected table name: 'lessons'
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            $table->timestamps();
      
            // Optional: Ensures a student can only have one progress entry per lesson
            $table->unique(['lesson_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_lesson_progresses');
    }
};