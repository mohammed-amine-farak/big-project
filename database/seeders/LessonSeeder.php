<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================
        // 1. التأكد من وجود المواد الدراسية
        // =========================================================
        $mathSubject = DB::table('subjects')->where('name', 'الرياضيات')->first();
        $physicsSubject = DB::table('subjects')->where('name', 'الفيزياء والكيمياء')->first();
        
        if (!$mathSubject || !$physicsSubject) {
            $this->command->error('❌ لم يتم العثور على المواد الدراسية');
            return;
        }

        // =========================================================
        // 2. إدراج الدروس للباحث 65
        // =========================================================
        $lessons = [
            // الرياضيات
            [
                'researcher_id' => 65,
                'title' => 'النهايات في الرياضيات',
                'content' => 'شرح مفصل لمفهوم النهايات في الرياضيات، تعريفها، قوانينها، وتطبيقاتها في حل المسائل المختلفة.',
                'subject_id' => $mathSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'المشتقات وتطبيقاتها',
                'content' => 'تعريف المشتقة، قواعد الاشتقاق الأساسية، تطبيقات المشتقات في إيجاد ميل المنحنى وسرعة التغير اللحظية.',
                'subject_id' => $mathSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'التكامل غير المحدود',
                'content' => 'مفهوم التكامل، طرق التكامل الأساسية، العلاقة بين التكامل والمشتقة، أمثلة محلولة.',
                'subject_id' => $mathSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'المصفوفات والمحددات',
                'content' => 'تعريف المصفوفات، العمليات عليها، حساب المحددات، تطبيقات في حل نظم المعادلات الخطية.',
                'subject_id' => $mathSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'الاحتمالات والإحصاء',
                'content' => 'مفاهيم أساسية في الاحتمالات، قوانين الاحتمالات، المتغيرات العشوائية، التوزيعات الاحتمالية.',
                'subject_id' => $mathSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // الفيزياء
            [
                'researcher_id' => 65,
                'title' => 'قوانين نيوتن للحركة',
                'content' => 'شرح قوانين الحركة الثلاثة، تطبيقاتها في الحياة اليومية، مسائل محلولة على كل قانون.',
                'subject_id' => $physicsSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'التيار الكهربائي وقانون أوم',
                'content' => 'مفهوم التيار الكهربائي، قانون أوم، المقاومات، طرق توصيل المقاومات على التوالي والتوازي.',
                'subject_id' => $physicsSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'المجال المغناطيسي',
                'content' => 'المجال المغناطيسي، القوة المغناطيسية، تطبيقات على حركة الجسيمات المشحونة في المجال المغناطيسي.',
                'subject_id' => $physicsSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'البصريات الهندسية',
                'content' => 'قوانين الانعكاس والانكسار، العدسات، المرايا، تكوين الصور في العدسات والمرايا.',
                'subject_id' => $physicsSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'researcher_id' => 65,
                'title' => 'الديناميكا الحرارية',
                'content' => 'قوانين الديناميكا الحرارية، الحرارة، الشغل، الطاقة الداخلية، تطبيقات على المحركات الحرارية.',
                'subject_id' => $physicsSubject->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($lessons as $lesson) {
            DB::table('lessonss')->insert($lesson);
        }

        $this->command->info('✅ تم إدراج 10 دروس للباحث 65 بنجاح');

        // =========================================================
        // 3. الحصول على معرفات الدروس
        // =========================================================
        $limitsLesson = DB::table('lessonss')->where('title', 'النهايات في الرياضيات')->where('researcher_id', 65)->first();
        $derivativesLesson = DB::table('lessonss')->where('title', 'المشتقات وتطبيقاتها')->where('researcher_id', 65)->first();
        $integrationLesson = DB::table('lessonss')->where('title', 'التكامل غير المحدود')->where('researcher_id', 65)->first();
        $newtonLesson = DB::table('lessonss')->where('title', 'قوانين نيوتن للحركة')->where('researcher_id', 65)->first();

        if (!$limitsLesson) {
            $this->command->error('❌ لم يتم العثور على الدروس المدرجة');
            return;
        }

        // =========================================================
        // 4. إدراج القواعد
        // =========================================================
        $rules = [
            // قواعد درس النهايات
            [
                'lessons_id' => $limitsLesson->id,
                'title' => 'تعريف النهاية',
               
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'lessons_id' => $limitsLesson->id,
                'title' => 'قوانين النهايات الأساسية',
               
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'lessons_id' => $limitsLesson->id,
                'title' => 'نهايات الدوال المثلثية',
              
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // قواعد درس المشتقات
            [
                'lessons_id' => $derivativesLesson->id,
                'title' => 'تعريف المشتقة',
              
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'lessons_id' => $derivativesLesson->id,
                'title' => 'قواعد الاشتقاق',
                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'lessons_id' => $derivativesLesson->id,
                'title' => 'تطبيقات المشتقات',
               
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // قواعد درس التكامل
            [
                'lessons_id' => $integrationLesson->id,
                'title' => 'التكامل غير المحدود',
               
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'lessons_id' => $integrationLesson->id,
                'title' => 'طرق التكامل الأساسية',
               
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // قواعد درس نيوتن
            [
                'lessons_id' => $newtonLesson->id,
                'title' => 'القانون الأول لنيوتن',
              
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'lessons_id' => $newtonLesson->id,
                'title' => 'القانون الثاني لنيوتن',
              
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'lessons_id' => $newtonLesson->id,
                'title' => 'القانون الثالث لنيوتن',
                
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($rules as $rule) {
            DB::table('rules')->insert($rule);
        }

        $this->command->info('✅ تم إدراج 11 قاعدة');
    }
}