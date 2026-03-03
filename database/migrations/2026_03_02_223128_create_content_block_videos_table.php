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
        Schema::create('content_block_videos', function (Blueprint $table) {
             $table->id();
    $table->unsignedBigInteger('content_block_id');  // كتلة المحتوى
    $table->unsignedBigInteger('video_id');          // الفيديو
                // الترتيب
    $table->timestamps();
    
    $table->foreign('content_block_id')->references('id')->on('content_blocks')->onDelete('cascade');
    $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
    
    // كل كتلة محتوى يمكن أن ترتبط بفيديو واحد فقط
    $table->unique('content_block_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_block_videos');
    }
};
