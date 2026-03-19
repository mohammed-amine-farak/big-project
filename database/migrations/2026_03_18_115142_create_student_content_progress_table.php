<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_content_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained('lessonss')->cascadeOnDelete();
            $table->foreignId('content_block_id')->constrained('content_blocks')->cascadeOnDelete();
            $table->boolean('viewed')->default(false);
            $table->boolean('completed')->default(false);
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // منع تكرار نفس الطالب لنفس كتلة المحتوى
            $table->unique(['student_id', 'content_block_id'], 'unique_student_content');
            
            // فهارس للبحث السريع
            $table->index(['student_id', 'lesson_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_content_progress');
    }
};