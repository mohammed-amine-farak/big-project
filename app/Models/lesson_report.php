<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lesson_report extends Model
{
    protected $fillable = [
        'lesson_id',
        'teacher_id',
        'researcher_id',
        'classroom_id',
        'title',
        'description',
        'problem_type',
        'priority',
        'status',
        'researcher_response',
        'affected_students',
        'resolved_at'
    ];

    public function lesson()
    {
        return $this->belongsTo(lessonss::class);
    }

    /**
     * Get the teacher that created the report.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the researcher that owns the lesson.
     */
    public function researcher()
    {
        return $this->belongsTo(researchers::class);
    }

    /**
     * Get the classroom where the problem occurred.
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
