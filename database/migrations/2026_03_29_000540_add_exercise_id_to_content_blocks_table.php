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
        Schema::table('content_blocks', function (Blueprint $table) {
         $table->foreignId('exercise_id')->nullable()->constrained('exercises')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
           $table->dropForeign(['exercise_id']); // أولاً إزالة الفوريجن
        $table->dropColumn('exercise_id');   // ثم إزالة العمود
        });
    }
};
