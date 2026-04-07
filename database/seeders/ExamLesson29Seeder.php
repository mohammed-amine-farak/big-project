<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Choice;
use App\Models\choices;
use App\Models\exams;
use App\Models\questions;

class ExamLesson29Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the exam
        $exam = exams::create([
            'researcher_id' => 65,
            'lesson_id' => 29,
            'title' => 'اختبار الرياضيات - الدرس 29',
            'subject' => 'الرياضيات',
            'start_time' => now(),
            'end_time' => now()->addMinutes(60),
        ]);

        // Question 1
        $question1 = questions::create([
            'exam_id' => $exam->id,
            'question_text' => 'ما هو ناتج 25 + 13؟',
        ]);
        
        choices::create(['question_id' => $question1->id, 'choice_text' => '38', 'is_correct' => true]);
        choices::create(['question_id' => $question1->id, 'choice_text' => '36', 'is_correct' => false]);
        choices::create(['question_id' => $question1->id, 'choice_text' => '40', 'is_correct' => false]);
        choices::create(['question_id' => $question1->id, 'choice_text' => '42', 'is_correct' => false]);

        // Question 2
        $question2 = questions::create([
            'exam_id' => $exam->id,
            'question_text' => 'ما هو ناتج 12 × 4؟',
        ]);
        
        choices::create(['question_id' => $question2->id, 'choice_text' => '44', 'is_correct' => false]);
        choices::create(['question_id' => $question2->id, 'choice_text' => '46', 'is_correct' => false]);
        choices::create(['question_id' => $question2->id, 'choice_text' => '48', 'is_correct' => true]);
        choices::create(['question_id' => $question2->id, 'choice_text' => '50', 'is_correct' => false]);

        // Question 3
        $question3 = questions::create([
            'exam_id' => $exam->id,
            'question_text' => 'ما هو ناتج 81 ÷ 9؟',
        ]);
        
        choices::create(['question_id' => $question3->id, 'choice_text' => '7', 'is_correct' => false]);
        choices::create(['question_id' => $question3->id, 'choice_text' => '8', 'is_correct' => false]);
        choices::create(['question_id' => $question3->id, 'choice_text' => '9', 'is_correct' => true]);
        choices::create(['question_id' => $question3->id, 'choice_text' => '10', 'is_correct' => false]);

        // Question 4
        $question4 = questions::create([
            'exam_id' => $exam->id,
            'question_text' => 'ما هو العدد التالي في المتتالية: 2, 4, 6, 8, ?',
        ]);
        
        choices::create(['question_id' => $question4->id, 'choice_text' => '9', 'is_correct' => false]);
        choices::create(['question_id' => $question4->id, 'choice_text' => '10', 'is_correct' => true]);
        choices::create(['question_id' => $question4->id, 'choice_text' => '11', 'is_correct' => false]);
        choices::create(['question_id' => $question4->id, 'choice_text' => '12', 'is_correct' => false]);

        // Question 5
        $question5 = questions::create([
            'exam_id' => $exam->id,
            'question_text' => 'ما هو ناتج 50 - 27؟',
        ]);
        
        choices::create(['question_id' => $question5->id, 'choice_text' => '23', 'is_correct' => true]);
        choices::create(['question_id' => $question5->id, 'choice_text' => '25', 'is_correct' => false]);
        choices::create(['question_id' => $question5->id, 'choice_text' => '27', 'is_correct' => false]);
        choices::create(['question_id' => $question5->id, 'choice_text' => '29', 'is_correct' => false]);

        $this->command->info('Exam created successfully with ID: ' . $exam->id);
        $this->command->info('Questions count: 5');
    }
}