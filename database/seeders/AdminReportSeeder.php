<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تحليل نتائج الطلاب في مادة الرياضيات للفصل الأول',
                'description' => 'نحتاج إلى تحليل شامل لنتائج الطلاب في مادة الرياضيات للفصل الدراسي الأول لتحديد نقاط الضعف والقوة وتقديم توصيات لتحسين الأداء.',
                'report_type' => 'academic',
                'priority' => 'high',
                'status' => 'pending',
                'researcher_response' => null,
             
                'deadline' => Carbon::now()->addDays(14),
                'resolved_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'دراسة تأثير المنصة التعليمية الجديدة على التحصيل الدراسي',
                'description' => 'مطلوب دراسة لتقييم تأثير المنصة التعليمية الجديدة على مستوى التحصيل الدراسي للطلاب ومعدلات حضور الحصص الافتراضية.',
                'report_type' => 'research',
                'priority' => 'medium',
                'status' => 'under_review',
                'researcher_response' => 'تم البدء في جمع البيانات الأولية من المعلمين والطلاب. نعمل حالياً على تحليل الاستبيانات الموزعة.',
              
                'deadline' => Carbon::now()->addDays(21),
                'resolved_at' => null,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تقرير عن احتياجات التدريب للمعلمين',
                'description' => 'تحليل احتياجات التدريب للمعلمين في المجالات التكنولوجية والتربوية بناءً على نتائج التقييم الأخير.',
                'report_type' => 'human_resources',
                'priority' => 'high',
                'status' => 'in_progress',
                'researcher_response' => 'جاري تحليل بيانات التقييمات ومراجعة الاحتياجات التدريبية مع رؤساء الأقسام.',
               
                'deadline' => Carbon::now()->addDays(7),
                'resolved_at' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'دراسة جدوى تحديث البنية التحتية التقنية',
                'description' => 'تحليل الجدوى الاقتصادية والفنية لتحديث البنية التحتية التقنية للمدرسة وتقديم توصيات حول الأولويات.',
                'report_type' => 'infrastructure',
                'priority' => 'critical',
                'status' => 'pending',
                'researcher_response' => null,
              
                'deadline' => Carbon::now()->addDays(30),
                'resolved_at' => null,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تحليل تكاليف التشغيل والميزانية المقترحة',
                'description' => 'دراسة مفصلة لتكاليف التشغيل الحالية واقتراح ميزانية للعام الدراسي القادم مع تحليل للبدائل.',
                'report_type' => 'financial',
                'priority' => 'high',
                'status' => 'resolved',
                'researcher_response' => 'تم الانتهاء من تحليل التكاليف وإعداد الميزانية المقترحة. تم تحديد فرص التوفير واقتراح أولويات الصرف.',
               
                'deadline' => Carbon::now()->subDays(5),
                'resolved_at' => Carbon::now()->subDays(2),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(2),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تقييم نظام الأمن والسلامة بالمدرسة',
                'description' => 'مراجعة شاملة لنظام الأمن والسلامة الحالي وتقديم توصيات للتحسين بناءً على المعايير الدولية.',
                'report_type' => 'security',
                'priority' => 'critical',
                'status' => 'in_progress',
                'researcher_response' => 'تم زيارة جميع مرافق المدرسة وإجراء مقابلات مع فريق الأمن. جاري إعداد التقرير النهائي.',
               
                'deadline' => Carbon::now()->addDays(10),
                'resolved_at' => null,
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(3),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'دراسة تحسين تجربة المستخدم للمنصة الإلكترونية',
                'description' => 'تحليل تجربة المستخدم الحالية للمنصة الإلكترونية وتقديم مقترحات لتحسين الواجهة وسهولة الاستخدام.',
                'report_type' => 'technical',
                'priority' => 'medium',
                'status' => 'pending',
                'researcher_response' => null,
              
                'deadline' => Carbon::now()->addDays(25),
                'resolved_at' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تقرير متابعة تنفيذ الخطة الاستراتيجية',
                'description' => 'مراجعة وتقييم مستوى تقدم تنفيذ الخطة الاستراتيجية للمدرسة للربع الأول من العام.',
                'report_type' => 'administrative',
                'priority' => 'medium',
                'status' => 'resolved',
                'researcher_response' => 'تم تقييم جميع مؤشرات الأداء ومراجعة التقارير الشهرية. الخطة تسير وفق الجدول الزمني مع بعض التحديات في المشاريع التقنية.',
               
                'deadline' => Carbon::now()->subDays(3),
                'resolved_at' => Carbon::now()->subDays(1),
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(1),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تحليل احتياجات المكتبة الرقمية',
                'description' => 'دراسة احتياجات الطلاب والمعلمين من المصادر الرقمية والمحتوى الإلكتروني للمكتبة.',
                'report_type' => 'academic',
                'priority' => 'low',
                'status' => 'closed',
                'researcher_response' => 'تم الانتهاء من الدراسة وتقديم التوصيات. المشروع تم تنفيذه بنجاح والمكتبة الرقمية تعمل الآن.',
                
                'deadline' => Carbon::now()->subDays(45),
                'resolved_at' => Carbon::now()->subDays(30),
                'created_at' => now()->subDays(60),
                'updated_at' => now()->subDays(30),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تقييم برامج الدعم النفسي للطلاب',
                'description' => 'دراسة تقييمية لبرامج الدعم النفسي والاجتماعي المقدمة للطلاب وتأثيرها على الصحة النفسية.',
                'report_type' => 'research',
                'priority' => 'medium',
                'status' => 'rejected',
                'researcher_response' => 'الدراسة تحتاج إلى موافقة لجنة الأخلاقيات البحثية أولاً. تم رفض الطلب حتى استكمال المتطلبات.',
               
                'deadline' => Carbon::now()->addDays(15),
                'resolved_at' => Carbon::now()->subDays(2),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(2),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'دراسة تحسين كفاءة استهلاك الطاقة',
                'description' => 'تحليل استهلاك الطاقة الحالي في مرافق المدرسة واقتراح حلول لتحسين الكفاءة وتقليل التكاليف.',
                'report_type' => 'infrastructure',
                'priority' => 'medium',
                'status' => 'pending',
                'researcher_response' => null,
                
                'deadline' => Carbon::now()->addDays(40),
                'resolved_at' => null,
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تقرير تقييم أداء البرامج الإثرائية',
                'description' => 'تقييم فعالية البرامج الإثرائية المقدمة للطلاب المتفوقين وتأثيرها على تطوير مهاراتهم.',
                'report_type' => 'academic',
                'priority' => 'high',
                'status' => 'in_progress',
                'researcher_response' => 'تم جمع بيانات من 85% من الطلاب المشاركين. جاري تحليل النتائج ومقارنتها بمجموعة التحكم.',
                
                'deadline' => Carbon::now()->addDays(12),
                'resolved_at' => null,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(2),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تحليل سوق العمل لخريجي التخصصات العلمية',
                'description' => 'دراسة متطلبات سوق العمل الحالية والمستقبلية لخريجي التخصصات العلمية وتطوير المناهج بناءً عليها.',
                'report_type' => 'research',
                'priority' => 'medium',
                'status' => 'under_review',
                'researcher_response' => 'تم الانتهاء من جمع البيانات من الشركات والمؤسسات. جاري مراجعة النتائج مع فريق التطوير الأكاديمي.',
               
                'deadline' => Carbon::now()->addDays(18),
                'resolved_at' => null,
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(5),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'تقرير جاهزية البنية التحتية للتعليم عن بعد',
                'description' => 'تقييم البنية التحتية الحالية للتعليم عن بعد ومدى جاهزيتها للطوارئ والظروف الاستثنائية.',
                'report_type' => 'technical',
                'priority' => 'high',
                'status' => 'resolved',
                'researcher_response' => 'تم تقييم جميع الأنظمة والشبكات. أوصينا بتحديث خوادم الفيديو كونفرنس وزيادة سعة الإنترنت.',
               
                'deadline' => Carbon::now()->subDays(7),
                'resolved_at' => Carbon::now()->subDays(3),
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(3),
            ],
            [
                'admin_id' => 5,
                'researcher_id' => 10,
                'title' => 'دراسة تحسين نظام التواصل مع أولياء الأمور',
                'description' => 'تحليل فعالية أنظمة التواصل الحالية مع أولياء الأمور واقتراح تحسينات لزيادة التفاعل والمشاركة.',
                'report_type' => 'administrative',
                'priority' => 'medium',
                'status' => 'pending',
                'researcher_response' => null,
               
                'deadline' => Carbon::now()->addDays(22),
                'resolved_at' => null,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
        ];

        // Clear existing records
        DB::table('admine_reports')->truncate();

        // Insert the reports
        DB::table('admine_reports')->insert($reports);

        $this->command->info('✅ تم إضافة 15 تقرير إداري بنجاح!');
        $this->command->info('👤 معرف المسؤول: 1');
        $this->command->info('🔬 معرف الباحث: 10');
        $this->command->info('📊 إحصائيات التقارير:');
        $this->command->info('   - قيد الانتظار: ' . collect($reports)->where('status', 'pending')->count());
        $this->command->info('   - قيد المراجعة: ' . collect($reports)->where('status', 'under_review')->count());
        $this->command->info('   - قيد المعالجة: ' . collect($reports)->where('status', 'in_progress')->count());
        $this->command->info('   - تم الحل: ' . collect($reports)->where('status', 'resolved')->count());
        $this->command->info('   - مغلق: ' . collect($reports)->where('status', 'closed')->count());
        $this->command->info('   - مرفوض: ' . collect($reports)->where('status', 'rejected')->count());
    }
}