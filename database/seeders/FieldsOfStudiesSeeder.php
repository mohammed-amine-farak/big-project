<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FieldsOfStudiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // بيانات المسالك التقنية للثانوي التأهيلي
        $fieldsOfStudies = [
            // =========================================================
            // الجذع المشترك (Common Core)
            // =========================================================
            [
                'name' => 'الجذع المشترك العلمي',
                'study_level' => 'Common Core',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'الجذع المشترك التكنولوجي',
                'study_level' => 'Common Core',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // =========================================================
            // الأولى بكالوريا (First Baccalaureate)
            // =========================================================
            [
                'name' => 'علوم رياضية - أ',
                'study_level' => 'First Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم رياضية - ب',
                'study_level' => 'First Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم فيزيائية',
                'study_level' => 'First Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم الحياة والأرض',
                'study_level' => 'First Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم زراعية',
                'study_level' => 'First Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم وتقنيات كهربائية',
                'study_level' => 'First Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم وتقنيات ميكانيكية',
                'study_level' => 'First Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            // =========================================================
            // الثانية بكالوريا (Second Baccalaureate)
            // =========================================================
            [
                'name' => 'علوم رياضية - أ',
                'study_level' => 'Second Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم رياضية - ب',
                'study_level' => 'Second Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم فيزيائية',
                'study_level' => 'Second Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم الحياة والأرض',
                'study_level' => 'Second Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم زراعية',
                'study_level' => 'Second Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم وتقنيات كهربائية',
                'study_level' => 'Second Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'علوم وتقنيات ميكانيكية',
                'study_level' => 'Second Baccalaureate',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        // إدراج البيانات في الجدول
        DB::table('fields_of_studies')->insert($fieldsOfStudies);
    }
}