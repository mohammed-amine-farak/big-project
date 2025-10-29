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
        Schema::create('lessonss', function (Blueprint $table) {
            $table->id();
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            
            $table->string('img')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('researcher_id')->references('id')->on('researchers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
