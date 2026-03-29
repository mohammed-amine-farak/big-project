<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLessonProgress extends Model
{
    protected $table = 'student_lesson_progress';

    protected $fillable = [
        'student_id',
        'lesson_id',
        'progress',
        'completed',
        'completed_at',
        'viewed_links',
        'last_accessed_at',
        'status'
    ];

    protected $casts = [
        'viewed_links' => 'array',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    /**
     * العلاقة مع الطالب
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * العلاقة مع الدرس
     */
    public function lesson()
    {
        return $this->belongsTo(lessonss::class, 'lesson_id');
    }

    /**
     * تحديث التقدم
     */
    public function updateProgress($newProgress)
    {
        $this->progress = min($newProgress, 100);
        
        if ($this->progress >= 100 && !$this->completed) {
            $this->completed = true;
            $this->completed_at = now();
        }
        
        $this->last_accessed_at = now();
        $this->save();
    }
}