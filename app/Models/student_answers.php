<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class student_answers extends Model
{
    protected $table = 'student_answers';
    
    protected $fillable = [
        'student_id',
        'question_id',
        'choice_id',
        'is_correct',
        'points_awarded'
    ];
    
    protected $casts = [
        'is_correct' => 'boolean',
        'points_awarded' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    /**
     * Get the student who gave this answer
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    
    /**
     * Get the question that was answered
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(questions::class, 'question_id');
    }
    
    /**
     * Get the chosen choice
     */
    public function choice(): BelongsTo
    {
        return $this->belongsTo(choices::class, 'choice_id');
    }
    
    /**
     * Scope a query to only include correct answers
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }
    
    /**
     * Scope a query to only include incorrect answers
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }
    
    /**
     * Scope a query to get answers for a specific student
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
    
    /**
     * Scope a query to get answers for a specific exam
     */
    public function scopeForExam($query, $examId)
    {
        return $query->whereHas('question', function($q) use ($examId) {
            $q->where('exam_id', $examId);
        });
    }
    
    /**
     * Get the points earned (alias for points_awarded)
     */
    public function getPointsAttribute()
    {
        return $this->points_awarded;
    }
    
    /**
     * Check if the answer is correct (alias)
     */
    public function isCorrect(): bool
    {
        return (bool) $this->is_correct;
    }
    
    /**
     * Calculate score for a student on a specific exam
     */
    public static function calculateExamScore($studentId, $examId)
    {
        return self::where('student_id', $studentId)
            ->whereHas('question', function($q) use ($examId) {
                $q->where('exam_id', $examId);
            })
            ->where('is_correct', true)
            ->count();
    }
    
    /**
     * Calculate total points for a student on a specific exam
     */
    public static function calculateExamPoints($studentId, $examId)
    {
        return self::where('student_id', $studentId)
            ->whereHas('question', function($q) use ($examId) {
                $q->where('exam_id', $examId);
            })
            ->sum('points_awarded');
    }
    
    /**
     * Get all answers for a student with their questions and choices
     */
    public static function getStudentAnswersWithDetails($studentId, $examId = null)
    {
        $query = self::with(['question', 'choice'])
            ->where('student_id', $studentId);
            
        if ($examId) {
            $query->whereHas('question', function($q) use ($examId) {
                $q->where('exam_id', $examId);
            });
        }
        
        return $query->get();
    }
    
    /**
     * Check if student has already answered a specific question
     */
    public static function hasAnswered($studentId, $questionId)
    {
        return self::where('student_id', $studentId)
            ->where('question_id', $questionId)
            ->exists();
    }
    
    /**
     * Get answer statistics for an exam
     */
    public static function getExamStatistics($examId)
    {
        $answers = self::whereHas('question', function($q) use ($examId) {
            $q->where('exam_id', $examId);
        })->get();
        
        return [
            'total_answers' => $answers->count(),
            'correct_answers' => $answers->where('is_correct', true)->count(),
            'incorrect_answers' => $answers->where('is_correct', false)->count(),
            'total_points' => $answers->sum('points_awarded'),
            'average_score' => $answers->avg('points_awarded'),
            'students_count' => $answers->groupBy('student_id')->count(),
        ];
    }
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-calculate points before saving if not manually set
        static::saving(function ($model) {
            if ($model->is_correct && $model->points_awarded == 0) {
                $model->points_awarded = 1;
            } elseif (!$model->is_correct && $model->points_awarded > 0) {
                $model->points_awarded = 0;
            }
        });
    }
}