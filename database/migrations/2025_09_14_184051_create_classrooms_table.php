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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('study_year_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('school_id');
            $table->string('class_name'); // اسم الفصل
            $table->string('class_name_ar'); // اسم الفصل بالعربية
            $table->string('grade_level'); // المستوى الدراسي
            $table->text('description')->nullable(); // وصف الفصل
            $table->integer('max_students')->default(30); // الحد الأقصى للطلاب
            $table->boolean('is_active')->default(true); // حالة الفصل
            
            $table->foreign('study_year_id')->references('id')->on('study_years')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
