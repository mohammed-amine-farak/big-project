<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =========================================================
        // 1. الحصول على معرفات المسالك الدراسية
        // =========================================================
        $fields = DB::table('fields_of_studies')->get()->keyBy(function($item) {
            return $item->name . '_' . $item->study_level;
        });

        // =========================================================
        // 2. بيانات المواد الدراسية
        // =========================================================
        $subjects = [
            // =========================================================
            // الرياضيات
            // =========================================================
            // الجذع المشترك العلمي
            [
                'name' => 'الرياضيات',
                'fields_id' => $fields['الجذع المشترك العلمي_Common Core']->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الرياضيات بالفرنسية',
                'fields_id' => $fields['الجذع المشترك العلمي_Common Core']->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // أولى باك علوم رياضية
            [
                'name' => 'الرياضيات',
                'fields_id' => $fields['علوم رياضية - أ_First Baccalaureate']->id ?? 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الرياضيات بالفرنسية',
                'fields_id' => $fields['علوم رياضية - أ_First Baccalaureate']->id ?? 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الرياضيات',
                'fields_id' => $fields['علوم رياضية - ب_First Baccalaureate']->id ?? 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // ثانية باك علوم رياضية
            [
                'name' => 'الرياضيات',
                'fields_id' => $fields['علوم رياضية - أ_Second Baccalaureate']->id ?? 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الرياضيات بالفرنسية',
                'fields_id' => $fields['علوم رياضية - أ_Second Baccalaureate']->id ?? 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // =========================================================
            // الفيزياء والكيمياء
            // =========================================================
            // الجذع المشترك العلمي
            [
                'name' => 'الفيزياء والكيمياء',
                'fields_id' => $fields['الجذع المشترك العلمي_Common Core']->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // أولى باك علوم فيزيائية
            [
                'name' => 'الفيزياء والكيمياء',
                'fields_id' => $fields['علوم فيزيائية_First Baccalaureate']->id ?? 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // ثانية باك علوم فيزيائية
            [
                'name' => 'الفيزياء',
                'fields_id' => $fields['علوم فيزيائية_Second Baccalaureate']->id ?? 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الكيمياء',
                'fields_id' => $fields['علوم فيزيائية_Second Baccalaureate']->id ?? 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // =========================================================
            // علوم الحياة والأرض
            // =========================================================
            // الجذع المشترك العلمي
            [
                'name' => 'علوم الحياة والأرض',
                'fields_id' => $fields['الجذع المشترك العلمي_Common Core']->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // أولى باك علوم الحياة والأرض
            [
                'name' => 'علوم الحياة والأرض',
                'fields_id' => $fields['علوم الحياة والأرض_First Baccalaureate']->id ?? 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // ثانية باك علوم الحياة والأرض
            [
                'name' => 'علوم الحياة والأرض',
                'fields_id' => $fields['علوم الحياة والأرض_Second Baccalaureate']->id ?? 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // =========================================================
            // العلوم الزراعية
            // =========================================================
            // أولى باك علوم زراعية
            [
                'name' => 'العلوم الزراعية',
                'fields_id' => $fields['علوم زراعية_First Baccalaureate']->id ?? 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // ثانية باك علوم زراعية
            [
                'name' => 'العلوم الزراعية',
                'fields_id' => $fields['علوم زراعية_Second Baccalaureate']->id ?? 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // =========================================================
            // العلوم التقنية
            // =========================================================
            // الجذع المشترك التكنولوجي
            [
                'name' => 'الهندسة الكهربائية',
                'fields_id' => $fields['الجذع المشترك التكنولوجي_Common Core']->id ?? 11,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الهندسة الميكانيكية',
                'fields_id' => $fields['الجذع المشترك التكنولوجي_Common Core']->id ?? 11,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // أولى باك علوم وتقنيات كهربائية
            [
                'name' => 'الهندسة الكهربائية',
                'fields_id' => $fields['علوم وتقنيات كهربائية_First Baccalaureate']->id ?? 12,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // أولى باك علوم وتقنيات ميكانيكية
            [
                'name' => 'الهندسة الميكانيكية',
                'fields_id' => $fields['علوم وتقنيات ميكانيكية_First Baccalaureate']->id ?? 13,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // ثانية باك علوم وتقنيات كهربائية
            [
                'name' => 'الهندسة الكهربائية',
                'fields_id' => $fields['علوم وتقنيات كهربائية_Second Baccalaureate']->id ?? 14,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الإلكترونيك',
                'fields_id' => $fields['علوم وتقنيات كهربائية_Second Baccalaureate']->id ?? 14,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // ثانية باك علوم وتقنيات ميكانيكية
            [
                'name' => 'الهندسة الميكانيكية',
                'fields_id' => $fields['علوم وتقنيات ميكانيكية_Second Baccalaureate']->id ?? 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الميكانيك',
                'fields_id' => $fields['علوم وتقنيات ميكانيكية_Second Baccalaureate']->id ?? 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // =========================================================
            // اللغات
            // =========================================================
            // الجذع المشترك العلمي
            [
                'name' => 'اللغة العربية',
                'fields_id' => $fields['الجذع المشترك العلمي_Common Core']->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'اللغة الفرنسية',
                'fields_id' => $fields['الجذع المشترك العلمي_Common Core']->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'اللغة الإنجليزية',
                'fields_id' => $fields['الجذع المشترك العلمي_Common Core']->id ?? 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // الجذع المشترك التكنولوجي
            [
                'name' => 'اللغة العربية',
                'fields_id' => $fields['الجذع المشترك التكنولوجي_Common Core']->id ?? 11,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'اللغة الفرنسية',
                'fields_id' => $fields['الجذع المشترك التكنولوجي_Common Core']->id ?? 11,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'اللغة الإنجليزية',
                'fields_id' => $fields['الجذع المشترك التكنولوجي_Common Core']->id ?? 11,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        // إدراج البيانات
        DB::table('subjects')->insert($subjects);
    }
}