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
        Schema::table('videos', function (Blueprint $table) {
          $table->foreignId('content_block_id')
                  ->nullable()
                  ->unique() // كل كتلة محتوى لها فيديو واحد فقط
                  ->constrained('content_blocks')
                  ->nullOnDelete()
                  ->after('production_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['content_block_id']);
            $table->dropColumn('content_block_id');
        });
    }
};
