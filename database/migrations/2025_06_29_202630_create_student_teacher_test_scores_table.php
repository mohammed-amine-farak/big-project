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
        Schema::create('student_teacher_test_scores', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id');

            $table->string('subject')->nullable();
            $table->text('test_title')->nullable();       // درجة أو تقييم
            $table->text('final_score')->nullable();       // ملاحظات نصية
            $table->text('comment')->nullable();
            $table->timestamps();

            // تعريف المفاتيح الأجنبية
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            // لتجنب تكرار العلاقة بين نفس الطالب والأستاذ في نفس المادة
            $table->unique(['student_id', 'teacher_id', 'subject']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_teacher_test_scores');
    }
};
