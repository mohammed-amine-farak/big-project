<?php
// database/migrations/xxxx_xx_xx_update_user_type_in_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // في MySQL، لا يمكن تعديل ENUM مباشرة، لذلك نستخدم استراتيجية مختلفة
        
        // 1. إنشاء عمود مؤقت
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type_temp')->nullable()->after('email');
        });

        // 2. نسخ البيانات من العمود القديم إلى الجديد
        DB::statement('UPDATE users SET user_type_temp = user_type');

        // 3. حذف العمود القديم
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });

        // 4. إنشاء العمود الجديد مع القيم المحدثة
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', [
                'teacher',      // معلم
                'researcher',   // باحث
                'parent',       // ولي أمر
                'student',      // طالب
                'admin',        // مدير
                'video_creator' // منشئ فيديوهات
            ])->default('student')->after('email');
        });

        // 5. استعادة البيانات من العمود المؤقت
        DB::statement('UPDATE users SET user_type = user_type_temp');

        // 6. حذف العمود المؤقت
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type_temp');
        });
    }

    public function down(): void
    {
        // العودة إلى الإصدار السابق
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type_temp')->nullable()->after('email');
        });

        DB::statement('UPDATE users SET user_type_temp = user_type');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', [
                'teacher',
                'parent',
                'student',
                'admin',
                'video_creator'
            ])->default('student')->after('email');
        });

        DB::statement('UPDATE users SET user_type = user_type_temp');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type_temp');
        });
    }
};