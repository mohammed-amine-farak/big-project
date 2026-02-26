<?php
// database/migrations/xxxx_xx_xx_add_account_status_to_users_table.php

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
        Schema::table('users', function (Blueprint $table) {
            // إضافة عمود حالة الحساب
            $table->enum('account_status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->after('user_type')
                  ->comment('pending: قيد المراجعة, approved: مقبول, rejected: مرفوض');
            
            // سبب الرفض (إذا تم رفض الحساب)
            $table->text('rejection_reason')
                  ->nullable()
                  ->after('account_status')
                  ->comment('سبب رفض الحساب');
            
            // تاريخ الموافقة أو الرفض
            $table->timestamp('approved_at')
                  ->nullable()
                  ->after('rejection_reason')
                  ->comment('تاريخ الموافقة على الحساب');
            
            // من قام بالموافقة أو الرفض
            $table->foreignId('approved_by')
                  ->nullable()
                  ->after('approved_at')
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('المدير الذي قام بالموافقة أو الرفض');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // حذف المفاتيح الأجنبية أولاً
            $table->dropForeign(['approved_by']);
            
            // حذف الأعمدة
            $table->dropColumn([
                'account_status',
                'rejection_reason',
                'approved_at',
                'approved_by'
            ]);
        });
    }
};