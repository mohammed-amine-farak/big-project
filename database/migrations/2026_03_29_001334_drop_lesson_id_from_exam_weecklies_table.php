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
        Schema::table('exam_weecklies', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            // ثم حذف العمود
            $table->dropColumn('lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_weecklies', function (Blueprint $table) {
            //
        });
    }
};
