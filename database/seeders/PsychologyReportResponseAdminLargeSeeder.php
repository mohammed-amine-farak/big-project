<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; 
use carbon\carbon;
class PsychologyReportResponseAdminLargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        // حذف البيانات السابقة إذا وجدت
        DB::table('psychology_report_response_admines')->truncate();

        $responses = [
            // حالة مقبولة
            [
                'student_psychology_id' => 29,
                'admin_id' => 1,
                'teacher_id' => 12,
                'status' => 'مقبول',
                'response_text' => 'تمت الموافقة على التقرير النفسي للطالب. نوصي بمتابعة الحالة مع المرشد النفسي المدرسي.',
                'recommendations' => 'مقابلة أسبوعية مع المرشد النفسي لمدة شهر.',
                'notes' => 'الطالب أظهر تحسناً ملحوظاً.',
                'requires_follow_up' => true,
                'follow_up_date' => Carbon::now()->addDays(30),
                'follow_up_notes' => 'متابعة بعد شهر من التدخل',
                'priority' => 'متوسط',
                'is_urgent' => false,
                'response_type' => 'توصيات_علاجية',
                'parent_notified' => true,
                'parent_notification_date' => Carbon::now()->subDays(2),
                'specialist_referred' => true,
                'specialist_type' => 'مرشد_نفسي',
                'specialist_notes' => 'تم تحويل الطالب إلى المرشد النفسي',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // حالة تحت المراجعة
            [
                'student_psychology_id' => 29,
                'admin_id' => 1,
                'teacher_id' => 12,
                'status' => 'تحت_المراجعة',
                'response_text' => 'التقرير قيد الدراسة. نحتاج إلى مزيد من المعلومات.',
                'recommendations' => null,
                'notes' => 'انتظار معلومات إضافية من المعلم',
                'requires_follow_up' => false,
                'follow_up_date' => null,
                'follow_up_notes' => null,
                'priority' => 'منخفض',
                'is_urgent' => false,
                'response_type' => 'ملاحظات_عامة',
                'parent_notified' => false,
                'parent_notification_date' => null,
                'specialist_referred' => false,
                'specialist_type' => null,
                'specialist_notes' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // حالة مرفوضة
            [
                'student_psychology_id' => 29,
                'admin_id' => 1,
                'teacher_id' => 12,
                'status' => 'مرفوض',
                'response_text' => 'تم رفض التقرير لعدم اكتمال المعلومات المطلوبة.',
                'recommendations' => 'يرجى إكمال النماذج المطلوبة وإعادة التقديم',
                'notes' => 'التقرير غير مكتمل',
                'requires_follow_up' => false,
                'follow_up_date' => null,
                'follow_up_notes' => null,
                'priority' => 'منخفض',
                'is_urgent' => false,
                'response_type' => 'غير_ذلك',
                'parent_notified' => false,
                'parent_notification_date' => null,
                'specialist_referred' => false,
                'specialist_type' => null,
                'specialist_notes' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // حالة عاجلة
            [
                'student_psychology_id' => 29,
                'admin_id' => 1,
                'teacher_id' => 12,
                'status' => 'مقبول',
                'response_text' => 'حالة عاجلة تتطلب تدخلاً فورياً. تم تحويل الطالب إلى طبيب نفسي.',
                'recommendations' => 'التقييم النفسي الفوري والمتابعة اليومية',
                'notes' => 'حالة طارئة',
                'requires_follow_up' => true,
                'follow_up_date' => Carbon::now()->addDays(7),
                'follow_up_notes' => 'متابعة بعد أسبوع',
                'priority' => 'عاجل',
                'is_urgent' => true,
                'response_type' => 'تحويل_لمختص',
                'parent_notified' => true,
                'parent_notification_date' => Carbon::now(),
                'specialist_referred' => true,
                'specialist_type' => 'طبيب_نفسي',
                'specialist_notes' => 'تم تحويل الحالة بشكل عاجل',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // حالة مكتملة
            [
                'student_psychology_id' => 29,
                'admin_id' => 1,
                'teacher_id' => 12,
                'status' => 'مكتمل',
                'response_text' => 'تم الانتهاء من معالجة التقرير بنجاح.',
                'recommendations' => 'يمكن اعتبار الحالة مغلقة',
                'notes' => 'جميع الإجراءات اكتملت',
                'requires_follow_up' => false,
                'follow_up_date' => null,
                'follow_up_notes' => null,
                'priority' => 'منخفض',
                'is_urgent' => false,
                'response_type' => 'متابعة_داخلية',
                'parent_notified' => true,
                'parent_notification_date' => Carbon::now()->subDays(5),
                'specialist_referred' => false,
                'specialist_type' => null,
                'specialist_notes' => null,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(5),
            ]
        ];

        // إدخال البيانات
        DB::table('psychology_report_response_admines')->insert($responses);
        
        $this->command->info('✅ تم إنشاء 5 سجلات اختبارية لـ psychology_report_response_admines');
    }
}
