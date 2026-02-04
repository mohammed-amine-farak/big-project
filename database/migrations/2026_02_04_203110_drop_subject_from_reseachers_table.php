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
        Schema::table('researchers', function (Blueprint $table) {
           $table->enum('subject', [
        'mathematics',
        'physics',
        'chemistry',
        'life_and_earth_sciences',
        'computer_science',
        'engineering_sciences',
        'arabic',
        'french',
        'english',
        'islamic_education'
    ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reseachers', function (Blueprint $table) {
         $table->dropColumn('subject');
        });
    }
};
