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
        Schema::create('rules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lessons_id');
            $table->string('title'); // عنوان القاعدة
            $table->text('description'); // شرح القاعدة
            $table->string('example')->nullable(); // مثال تطبيقي إن وجد
            $table->timestamps();

            $table->foreign('lessons_id')->references('id')->on('lessonss')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
