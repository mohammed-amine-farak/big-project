<?php

namespace App\Http\Controllers;


use App\Models\exams;
use App\Models\Lessonss;
use App\Models\student_answers;
use App\Models\StudentAnswer;
use App\Models\StudentLessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentExamController extends Controller
{
    public function show(exams $exam)
    {
        $student =17;
        $lesson = $exam->lesson;
        
        // Load exam with questions and choices
        $exam->load(['questions.choices']);
        
        // Check if student has already taken this exam
        $hasTaken = student_answers::where('student_id', $student)
            ->whereIn('question_id', $exam->questions->pluck('id'))
            ->exists();
        
        return view('student-dashboard.exam.show', compact('exam', 'student', 'hasTaken', 'lesson'));
    }
    
 public function submit(Request $request, exams $exam)
{
    $student = 17;
    
    $request->validate([
        'answers' => 'required|array',
        'answers.*' => 'nullable|exists:choices,id'
    ]);
    
    // Check if already submitted
    $existingAnswers = student_answers::where('student_id', $student)
        ->whereIn('question_id', $exam->questions->pluck('id'))
        ->exists();
        
    if ($existingAnswers) {
        return redirect()->route('student.exam.show', $exam)
            ->with('error', 'لقد قمت بالفعل بحل هذا الاختبار');
    }
    
    $correctAnswers = 0;
    $totalQuestions = $exam->questions->count();
    
    foreach ($request->answers as $questionId => $choiceId) {
        $question = $exam->questions()->find($questionId);
        if (!$question) continue;
        
        $choice = $question->choices()->find($choiceId);
        $isCorrect = $choice && $choice->is_correct;
        
        if ($isCorrect) {
            $correctAnswers++;
        }
        
        student_answers::create([
            'student_id' => $student,
            'question_id' => $questionId,
            'choice_id' => $choiceId,
            'is_correct' => $isCorrect,
            'points_awarded' => $isCorrect ? 1 : 0
        ]);
    }
    
    // ==============================================
    // Progress = (Correct Answers / Total Questions) × 40
    // Maximum progress from exam is 40%
    // ==============================================
    $lesson = $exam->lesson;
    
    $progress = StudentLessonProgress::firstOrCreate([
        'student_id' => $student,
        'lesson_id' => $lesson->id
    ]);
    
    // Calculate progress based on correct answers (max 40%)
    $progressPercentage = ($correctAnswers / $totalQuestions) * 40;
    
    // Update progress
    $progress->update([
        'progress' => round($progressPercentage, 2),
        'last_accessed_at' => now()
    ]);
    
    return redirect()->route('student.exam.results', $exam)
        ->with('success', 'تم إرسال الاختبار بنجاح');
} 
    public function results(exams $exam)
    {
        $student = 17;
        $lesson = $exam->lesson;
        
        $answers = student_answers::where('student_id', $student)
            ->whereIn('question_id', $exam->questions->pluck('id'))
            ->with(['question', 'question.choices', 'choice'])
            ->get();
            
        if ($answers->isEmpty()) {
            return redirect()->route('student.exam.show', $exam)
                ->with('error', 'لم تقم بحل الاختبار بعد');
        }
        
        $totalQuestions = $exam->questions->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $scorePercentage = ($correctAnswers / $totalQuestions) * 100;
        $passed = $scorePercentage >= 60;
        
        return view('student-dashboard.exam.results', compact('exam', 'answers', 'totalQuestions', 'correctAnswers', 'scorePercentage', 'passed', 'lesson'));
    }
}