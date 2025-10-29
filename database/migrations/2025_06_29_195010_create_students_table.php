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
        Schema::create('students', function (Blueprint $table) {
            // هنا id هو المفتاح الأساسي ومفتاح أجنبي مرتبط بـ users.id
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');

            $table->string('school_level')->nullable();
            $table->string('score_level')->nullable();
            
            $table->date('birth_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
