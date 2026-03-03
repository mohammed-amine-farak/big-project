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
        Schema::create('media_libraries', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('video_creator_id');
    
    $table->string('title');
    $table->enum('type', ['image', 'audio', 'template', 'font', 'effect']);
    $table->string('file_path');
    $table->string('thumbnail')->nullable();
    $table->integer('file_size')->nullable();
    $table->json('tags')->nullable();
    $table->boolean('is_public')->default(false);
    
    $table->timestamps();
    
    $table->foreign('video_creator_id')->references('id')->on('video_creators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_libraries');
    }
};
