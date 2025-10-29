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
        Schema::create('researchers', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        
            $table->string('field_of_study')->nullable();
            $table->string('institution')->nullable();
        
            $table->string('country')->nullable();
            $table->string('city')->nullable();
        
            $table->enum('degree', ['Master', 'PhD']);
        
            $table->string('certificate_path')->nullable();  // مسار ملف الشهادة
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researchers');
    }
};
