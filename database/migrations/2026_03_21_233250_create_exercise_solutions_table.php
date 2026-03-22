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
        Schema::create('exercise_solutions', function (Blueprint $table) {
          $table->id();
            // الربط مع بلوك التمرين في جدول content_blocks
            $table->foreignId('content_block_id')
                  ->constrained('content_blocks')
                  ->cascadeOnDelete();

            $table->longText('solution_text'); // الحل التفصيلي (يدعم LaTeX)
            $table->text('hint')->nullable();  // تلميح لمساعدة الطالب
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_solutions');
    }
};
