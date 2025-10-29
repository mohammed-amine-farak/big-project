<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction_Notes_students extends Model
{
    protected $fillable = [
        'student_id',
        'lesson_id',
        'teacher_id', 
        'note_content',
        'status',

    ];
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
   

    /**
     * Get the teacher that owns the interaction note.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    /**
     * Get the lesson that the interaction note belongs to.
     */
    public function lesson()
    {
        return $this->belongsTo(lessonss::class,'lesson_id');
    }
}
