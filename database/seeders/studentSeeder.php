<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\student;
use Illuminate\Support\Facades\DB;
class studentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = [
            // Month 1 - Tracking Progress
            [
                'id' => 18,
              
                
            ],
             [
                'id' => 19,
              
                
            ],
             [
                'id' => 20,
              
                
            ],

                         [
                'id' => 21,
              
                
            ],
                         [
                'id' => 22,
              
                
            ],
                         [
                'id' => 23,
              
                
            ],             [
                'id' => 24,
              
                
            ],
                         [
                'id' => 25,
              
                
            ],
                    [
                'id' => 26,
              
                
            ],
                            [
                    'id' => 27,
                
                    
                ],
                            [
                    'id' => 28,
                
                    
                ],  

        ];
        DB::table('students')->insert($student);
    }
}
