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
        Schema::table('rule_examples', function (Blueprint $table) {
            $table->string('image_url')->nullable();
            // Add image_alt_ar for accessibility and SEO
            $table->string('image_alt_ar')->nullable()->after('image_url');
            // Add image_caption_ar for descriptions
            $table->string('image_caption_ar')->nullable()->after('image_alt_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rule_examples', function (Blueprint $table) {
            //
        });
    }
};
