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
        Schema::create('admine_reports', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('admin_id'); // User who sends the report
          
            $table->unsignedBigInteger('researcher_id')->nullable(); // Specific researcher for research-related reports
           
            
            $table->string('title');
            $table->text('description');
            $table->enum('report_type', [
                'financial',
                'administrative', 
                'technical',
                'human_resources',
                'infrastructure',
                'academic',
                'research', // Added research type
                'security',
                'other'
            ])->default('administrative');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', [
                'pending',
                'under_review', 
                'in_progress',
                'resolved',
                'rejected',
                'closed'
            ])->default('pending');
            
            $table->text('researcher_response')->nullable(); // Added researcher response
          
            $table->json('related_documents')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->timestamp('resolved_at')->nullable();
          
            
            // Foreign keys
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('researcher_id')->references('id')->on('researchers')->onDelete('set null');

            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admine_reports');
    }
};
