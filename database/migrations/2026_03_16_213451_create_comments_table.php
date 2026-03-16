<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            
            // ✅ Polymorphic relation (يمكن التعليق على فيديو، درس، طلب إنتاج)
            $table->morphs('commentable');
            
            // ✅ صاحب التعليق (user يمكن أن يكون طالب، باحث، منشئ فيديو)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // ✅ محتوى التعليق
            $table->text('content');
            
            // ✅ Self-referencing for replies (الردود)
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            
            // ✅ الحالة والإحصائيات
            $table->boolean('is_approved')->default(true);
            $table->timestamp('read_at')->nullable();
            $table->integer('likes_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // ✅ فهارس للبحث السريع
          
            $table->index('created_at');
            $table->index('user_id');
            $table->index('parent_id');
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};