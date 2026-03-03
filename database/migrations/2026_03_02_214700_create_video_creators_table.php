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
        Schema::create('video_creators', function (Blueprint $table) {
                $table->unsignedBigInteger('id');  // سيكون مفتاح رئيسي وأجنبي
            $table->primary('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
    $table->string('specialization');                 // التخصص (رياضيات، فيزياء...)
    $table->json('skills');                           // المهارات ["مونتاج", "رسوم متحركة"]
    $table->string('portfolio_url')->nullable();      // رابط معرض الأعمال
    $table->string('preferred_software')->nullable(); // البرامج المفضلة
    $table->integer('completed_videos')->default(0);  // عدد الفيديوهات المنجزة
    $table->float('average_rating')->default(0);      // متوسط التقييم
    $table->integer('total_ratings')->default(0);     // عدد التقييمات
    $table->integer('total_rating_sum')->default(0);  // مجموع التقييمات
    $table->enum('status', ['active', 'busy', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_creators');
    }
};
