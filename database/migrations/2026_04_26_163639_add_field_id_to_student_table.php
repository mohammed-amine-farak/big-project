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
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('fields_id')->nullable()->after('id');
            
            // Add foreign key constraint
            $table->foreign('fields_id')
                  ->references('id')
                  ->on('fields_of_studies')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['fields_id']);
            
            // Then drop the column
            $table->dropColumn('fields_id');
        });
    }
};