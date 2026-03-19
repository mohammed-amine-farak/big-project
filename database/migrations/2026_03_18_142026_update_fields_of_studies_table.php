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
        Schema::table('fields_of_studies', function (Blueprint $table) {
            // إزالة unique القديم
            $table->dropUnique(['name']);
            
            // إضافة unique جديد (name + study_level)
            $table->unique(['name', 'study_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
