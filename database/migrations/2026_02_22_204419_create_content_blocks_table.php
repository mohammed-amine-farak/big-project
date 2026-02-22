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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rule_id')
                  ->constrained('rules')
                  ->cascadeOnDelete();

            // Block Type
            $table->enum('type', [
                'text',
                'math',
                'image',
                'video',
                'exercise'
            ]);

            // Content (LaTeX, HTML, URL...)
            $table->longText('content');

            // Order for display
            $table->integer('block_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
