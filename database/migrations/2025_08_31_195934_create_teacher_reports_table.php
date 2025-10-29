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
        Schema::create('teacher_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('researcher_id'); // Corrected: Added the missing column
            $table->unsignedBigInteger('lessons_id');
        
            $table->text('content');
            $table->enum('status', ['pending', 'reviewed'])->default('pending');
            $table->date('week');
        
            $table->timestamps();
        
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('researcher_id')->references('id')->on('researchers')->onDelete('cascade');
            $table->foreign('lessons_id')->references('id')->on('lessonss')->onDelete('cascade'); // Corrected: Fixed the typo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_reports');
    }
};
