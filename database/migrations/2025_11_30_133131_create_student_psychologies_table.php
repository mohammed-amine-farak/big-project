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
        Schema::create('student_psychologies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');//
            $table->unsignedBigInteger('teacher_id');
           $table->unsignedBigInteger('classroom_id');
            
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        
        // الجوانب النفسية
        $table->enum('mood', ['مبتهج', 'هادئ', 'قلق', 'حزين', 'غاضب', 'متحمس']);
        $table->enum('social_interaction', ['منطوي', 'متواصل_بشكل_معتدل', 'اجتماعي', 'قائد_مجموعة']);
        $table->enum('concentration', ['ضعيف', 'متوسط', 'جيد', 'ممتاز']);
        $table->enum('participation', ['سلبي', 'مشارك_أحياناً', 'نشط', 'مبادر']);
        $table->enum('behavior', ['ممتاز', 'جيد', 'مقبول', 'يحتاج_تحسين']);
        
        // ملاحظات إضافية
        $table->text('strengths')->nullable(); // نقاط القوة
        $table->text('challenges')->nullable(); // التحديات
        $table->text('recommendations')->nullable(); // توصيات
        $table->text('general_notes')->nullable(); // ملاحظات عامة
        $table->text('teacher_note')->nullable(); // ملاحظة المعلم الشخصية
        
        // حالة التقرير
        $table->enum('status', ['مسودة', 'مرسل_للإدارة'])->default('مسودة');
        
       $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_psychologies');
    }
};
