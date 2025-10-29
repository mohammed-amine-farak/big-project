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
        Schema::create('interaction__notes_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id'); // Column to hold the lesson ID
            $table->unsignedBigInteger('student_id'); // Column to hold the student ID
            $table->unsignedBigInteger('teacher_id');
          
            $table->text('note_content'); // The actual note/comment from the teacher
            
            $table->foreign('lesson_id')->references('id')->on('lessonss')->onDelete('cascade'); // Corrected table name: 'lessons'
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->softDeletes(); // For soft deleting notes
            $table->timestamps(); // includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interaction__notes_students');
    }
};
