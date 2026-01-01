<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
     
         Schema::disableForeignKeyConstraints();
        
        // Clear existing data
        DB::table('classrooms')->truncate();
        
        // Re-enable foreign key constraints
        Schema::enableForeignKeyConstraints();
        
        $classrooms = [
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Mathematics 101',
                'class_name_ar' => 'رياضيات ١٠١',
                'grade_level' => 'Grade 10',
                'description' => 'Introduction to Algebra and Geometry',
                'max_students' => 30,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Science Fundamentals',
                'class_name_ar' => 'أساسيات العلوم',
                'grade_level' => 'Grade 9',
                'description' => 'Basic principles of Physics and Chemistry',
                'max_students' => 25,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'English Literature',
                'class_name_ar' => 'الأدب الإنجليزي',
                'grade_level' => 'Grade 11',
                'description' => 'Classic English literature and composition',
                'max_students' => 28,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'History Class',
                'class_name_ar' => 'صف التاريخ',
                'grade_level' => 'Grade 10',
                'description' => 'World history and civilizations',
                'max_students' => 30,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Computer Science',
                'class_name_ar' => 'علوم الحاسوب',
                'grade_level' => 'Grade 12',
                'description' => 'Introduction to programming and algorithms',
                'max_students' => 20,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Physical Education',
                'class_name_ar' => 'التربية البدنية',
                'grade_level' => 'Grade 9',
                'description' => 'Sports and physical fitness activities',
                'max_students' => 35,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Advanced Mathematics',
                'class_name_ar' => 'رياضيات متقدمة',
                'grade_level' => 'Grade 12',
                'description' => 'Calculus and advanced mathematics',
                'max_students' => 25,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Arabic Language',
                'class_name_ar' => 'اللغة العربية',
                'grade_level' => 'Grade 10',
                'description' => 'Arabic grammar and literature',
                'max_students' => 30,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Art Class',
                'class_name_ar' => 'صف الفن',
                'grade_level' => 'Grade 9',
                'description' => 'Drawing and painting techniques',
                'max_students' => 22,
                'is_active' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'study_year_id' => 1,
                'teacher_id' => 12,
                'subject_id' => 1,
                'school_id' => 1,
                'class_name' => 'Music Theory',
                'class_name_ar' => 'نظرية الموسيقى',
                'grade_level' => 'Grade 11',
                'description' => 'Fundamentals of music and instruments',
                'max_students' => 18,
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert the data
        DB::table('classrooms')->insert($classrooms);
        
        $this->command->info('✓ Seeded ' . count($classrooms) . ' classrooms.');
    }
}