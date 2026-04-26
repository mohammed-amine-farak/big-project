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
             $table->string('father_name')->nullable()->after('transcript_path');
            $table->string('father_job')->nullable()->after('father_name');
            $table->string('father_phone')->nullable()->after('father_job');
            $table->string('father_email')->nullable()->after('father_phone');
            
            // Mother Information
            $table->string('mother_name')->nullable()->after('father_email');
            $table->string('mother_job')->nullable()->after('mother_name');
            $table->string('mother_phone')->nullable()->after('mother_job');
            $table->string('mother_email')->nullable()->after('mother_phone');
            
            // Family Information
            $table->text('parent_address')->nullable()->after('mother_email');
            $table->enum('family_situation', ['married', 'divorced', 'widowed', 'separated'])->nullable()->after('parent_address');
            $table->integer('number_of_siblings')->default(0)->after('family_situation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
