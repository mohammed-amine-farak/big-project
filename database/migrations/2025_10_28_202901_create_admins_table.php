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
        Schema::create('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('id');  // Primary key and foreign key
            $table->primary('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        
            // Personal Information
            $table->string('national_id')->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('personal_email')->nullable();
            
            // Professional Information
            $table->string('employee_id')->unique()->nullable();
            $table->enum('admin_type', [
                'super_admin',
                'school_admin', 
                'academic_admin',
                'financial_admin',
                'hr_admin',
                'technical_admin',
                'research_admin'
            ])->default('super_admin');
            $table->string('school_level')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('qualification')->nullable();
            $table->string('specialization')->nullable();
            
          
            
           
         
            
            // Contact Information
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            
            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            
        
            $table->json('documents')->nullable(); // CV, contracts, certificates, etc.
            $table->string('photo')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'suspended', 'on_leave'])->default('active');
            $table->text('notes')->nullable();
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
