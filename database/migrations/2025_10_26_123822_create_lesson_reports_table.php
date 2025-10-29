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
        Schema::create('lesson_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('researcher_id');
            $table->unsignedBigInteger('classroom_id'); // Specific classroom
            $table->string('title');
            $table->text('description');
            $table->enum('problem_type', ['content_issue', 'difficulty_level', 'technical_issue', 'language_issue', 'other'])->default('content_issue');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['pending', 'under_review', 'resolved', 'closed'])->default('pending');
            $table->text('researcher_response')->nullable();
            $table->json('affected_students')->nullable(); // Store student IDs or names
            $table->timestamp('resolved_at')->nullable();
            
            // Foreign keys
            $table->foreign('lesson_id')->references('id')->on('lessonss')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('researcher_id')->references('id')->on('researchers')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_reports');
    }
};
