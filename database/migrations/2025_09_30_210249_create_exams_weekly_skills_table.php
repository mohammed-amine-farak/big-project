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
        Schema::create('exams_weekly_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_level');
            $table->foreign('id_level')->references('id')->on('level_skills')->onDelete('cascade');
            $table->unsignedBigInteger('exams_weekly_id');
            $table->foreign('exams_weekly_id')->references('id')->on('exam_weecklies')->onDelete('cascade');
            $table->enum('status', ['send','in_progress'])
            ->nullable()
            ->default('in_progress'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams_weekly_skills');
    }
};
