<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\study_year;
use Carbon\Carbon;

class StudyYearSeeder extends Seeder
{
    public function run()
    {
        $years = [
            [
                'year_name' => '2023-2024',
                'year_name_ar' => '2023-2024',
                'is_active' => true,
                'start_date' => '2023-09-01',
                'end_date' => '2024-06-30'
            ],
            [
                'year_name' => '2024-2025', 
                'year_name_ar' => '2024-2025',
                'is_active' => false,
                'start_date' => '2024-09-01',
                'end_date' => '2025-06-30'
            ]
        ];

        foreach ($years as $year) {
            study_year::create($year);
        }
    }
}