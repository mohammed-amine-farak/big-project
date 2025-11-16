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
        Schema::table('interaction__notes_students', function (Blueprint $table) {
             $table->enum('status', ['send', 'In_process'])
                  ->nullable()
                  ->default('In_process'); 
                  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interaction__notes_students', function (Blueprint $table) {
            //
        });
    }
};
