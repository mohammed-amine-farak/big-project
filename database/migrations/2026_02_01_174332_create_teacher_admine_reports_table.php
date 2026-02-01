<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_admin_reports', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('admin_id')
                  ->constrained('admins')
                  ->cascadeOnDelete();

            $table->foreignId('teacher_id')
                  ->nullable()
                  ->constrained('teachers')
                  ->nullOnDelete();

            // Report content
            $table->string('title');
            $table->text('description');

            // Classification
            $table->string('report_type')->default('administrative');
            $table->string('priority')->default('medium');

            // Tracking
            $table->boolean('is_read')->default(false);
            $table->timestamp('deadline')->nullable();

            // Attachments
            $table->json('related_documents')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_admin_reports');
    }
};
