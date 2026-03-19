<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentContentProgress extends Model
{
    protected $table = 'student_content_progress';

    protected $fillable = [
        'student_id',
        'lesson_id',
        'content_block_id',
        'viewed',
        'completed',
        'viewed_at',
        'completed_at'
    ];

    protected $casts = [
        'viewed' => 'boolean',
        'completed' => 'boolean',
        'viewed_at' => 'datetime',
        'completed_at' => 'datetime',
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
     * العلاقة مع كتلة المحتوى
     */
    public function content_blocks()
    {
        return $this->belongsTo(content_blocks::class);
    }

    /**
     * تعليم الكتلة كمشاهدة
     */
    public function markAsViewed()
    {
        $this->viewed = true;
        $this->viewed_at = now();
        $this->save();
    }

    /**
     * تعليم الكتلة كمكتملة
     */
    public function markAsCompleted()
    {
        $this->completed = true;
        $this->completed_at = now();
        $this->save();
    }
}