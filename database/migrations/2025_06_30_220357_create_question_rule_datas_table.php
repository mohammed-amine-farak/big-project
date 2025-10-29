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
        Schema::create('question_rule_datas', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('question_id');
    $table->unsignedBigInteger('rule_id');
    $table->unsignedBigInteger('researcher_id'); // الباحث الذي أضاف البيانات

    $table->text('content')->nullable();    // نص الشرح أو الملاحظات
    $table->json('metadata')->nullable();  // بيانات إضافية إذا أردت (مثلاً روابط أو مصادر)

    $table->timestamps();

    $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
    $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');
    $table->foreign('researcher_id')->references('id')->on('users')->onDelete('cascade');
    
    $table->unique(['question_id', 'rule_id', 'researcher_id']); // نفس الباحث لا يدخل تكرار
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_rule_datas');
    }
};
