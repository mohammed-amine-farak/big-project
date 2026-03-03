<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_requests', function (Blueprint $table) {
            $table->id();

            // ✅ العلاقات الأساسية (صحيحة)
            $table->foreignId('researcher_id')
                  ->constrained('researchers')
                  ->cascadeOnDelete();

            $table->foreignId('video_creator_id')
                  ->nullable()
                  ->constrained('video_creators')
                  ->nullOnDelete();

            // ✅ المحتوى المرتبط - تم إصلاح المشكلة
            $table->foreignId('lesson_id')
                  ->constrained('lessonss')
                  ->cascadeOnDelete();

            // ✅ ملاحظة: rule_id و content_block_id ليسا ضروريين هنا
            // لأنه يمكن الوصول لهما عبر lesson_id والعلاقات في الكود
            // ولكن إذا أردت الاحتفاظ بهما:
            
            $table->foreignId('rule_id')
                  ->nullable()
                  ->constrained('rules')
                  ->nullOnDelete();  // ✅ nullOnDelete أفضل هنا

            $table->foreignId('content_block_id')
                  ->nullable()
                  ->constrained('content_blocks')
                  ->nullOnDelete();  // ✅ nullOnDelete أفضل هنا

            // ✅ تفاصيل الطلب
            $table->string('title');
            $table->text('description');
            
            // ✅ ملف مرجعي - أفضل بهذه الطريقة
            $table->string('reference_file')->nullable(); // اسم الملف فقط
            // أو
            $table->string('reference_file_path')->nullable(); // المسار الكامل

            $table->date('deadline')->nullable();

            // ✅ حالة الطلب - ممتازة
            $table->enum('status', [
                'pending',           // في الانتظار
                'accepted',          // تم القبول
                'submitted',         // تم التسليم
                'revision_required', // يحتاج تعديل
                'approved',          // تمت الموافقة
                'rejected'           // مرفوض نهائيًا
            ])->default('pending');

            // ✅ إضافة تواريخ مهمة مفقودة
            $table->timestamp('accepted_at')->nullable();   // تاريخ القبول
            $table->timestamp('submitted_at')->nullable();  // تاريخ التسليم
            $table->timestamp('approved_at')->nullable();   // تاريخ الموافقة

            // ✅ ماذا يجب تعديله
            $table->text('revision_details')->nullable();

            // ✅ ملاحظات عامة
            $table->text('notes')->nullable();

            // ✅ تقييم منشئ الفيديو (يضاف عند الموافقة)
           
            $table->timestamps();
            
            // ✅ إضافة فهارس لتحسين الأداء
            $table->index('status');
            $table->index('deadline');
            $table->index(['researcher_id', 'status']);
            $table->index(['video_creator_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_requests');
    }
};