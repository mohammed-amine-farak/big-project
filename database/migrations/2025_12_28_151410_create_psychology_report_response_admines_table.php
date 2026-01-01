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
        Schema::create('psychology_report_response_admines', function (Blueprint $table) {
                      $table->id();
            
            // Foreign Keys
            $table->unsignedBigInteger('student_psychology_id');
            $table->unsignedBigInteger('admin_id')->nullable(); 
            $table->unsignedBigInteger('teacher_id'); // Original teacher for reference
            
            // Response Details
            $table->enum('status', [
                'مقبول',
                'مرفوض', 
                'تحت_المراجعة',
                'مكتمل',
                'بحاجة_لمزيد_من_المعلومات',
                'تم_المعالجة'
            ])->default('تحت_المراجعة');
            
            $table->text('response_text'); // Main response from admin
            $table->text('recommendations')->nullable(); // Recommendations from admin
            $table->text('notes')->nullable(); // Additional notes
            
            // Follow-up information
            $table->boolean('requires_follow_up')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->text('follow_up_notes')->nullable();
            
            // Priority and urgency
            $table->enum('priority', ['منخفض', 'متوسط', 'مرتفع', 'عاجل'])->default('متوسط');
            $table->boolean('is_urgent')->default(false);
            
            // Response type
            $table->enum('response_type', [
                'ملاحظات_عامة',
                'توصيات_علاجية',
                'تحويل_لمختص',
                'متابعة_داخلية',
                'إشعار_لأولياء_الأمور',
                'غير_ذلك'
            ])->default('ملاحظات_عامة');
            
            // Actions taken
            $table->boolean('parent_notified')->default(false);
            $table->date('parent_notification_date')->nullable();
            $table->boolean('specialist_referred')->default(false);
            $table->enum('specialist_type', [
        'طبيب_نفسي',
        'مرشد_نفسي',
        'أخصائي_اجتماعي',
        'أخصائي_تربوي',
        'طبيب_عام',
        'أخصائي_نطق_ولغة',
        'أخصائي_علاج_وظيفي',
        'أخصائي_تعليم_خاص',
        'غير_ذلك'
    ])->nullable();
            $table->text('specialist_notes')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign Key Constraints
            $table->foreign('student_psychology_id')
                  ->references('id')
                  ->on('student_psychologies')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            $table->foreign('admin_id')
                  ->references('id')
                  ->on('admins')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
                  
            $table->foreign('teacher_id')
                  ->references('id')
                  ->on('teachers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
         


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychology_report_response_admines');
    }
};
