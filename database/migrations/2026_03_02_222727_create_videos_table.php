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
        Schema::create('videos', function (Blueprint $table) {
    $table->id();
    
    // العلاقات
    $table->foreignId('creator_id')
          ->constrained('video_creators')
          ->cascadeOnDelete();
          
    $table->foreignId('production_request_id')
          ->nullable()
          ->constrained('production_requests')
          ->nullOnDelete();
    
    // معلومات الفيديو
    $table->string('title');
    $table->text('description')->nullable();
    $table->string('file_path');
    $table->string('thumbnail')->nullable();
    $table->integer('duration')->nullable(); // المدة بالثواني
    $table->string('video_format')->default('mp4');
    $table->integer('file_size')->nullable(); // حجم الملف بـ MB
    
    // إحصائيات المشاهدة (تتجمع مع الوقت)
    $table->integer('views')->default(0);
    $table->integer('likes')->default(0);
    $table->float('completion_rate')->default(0); // نسبة المشاهدة الكاملة
    
    // ❌ تم حذف status نهائياً
    
    
    
    $table->timestamps();
    $table->softDeletes();
    
    // فهارس لتحسين الأداء
    $table->index('creator_id');
    $table->index('production_request_id');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
