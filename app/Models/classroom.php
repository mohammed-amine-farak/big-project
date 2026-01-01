<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classroom extends Model
{
    public function examWeeklies()
    {
        return $this->hasMany(exam_weeckly::class);
    }  
    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_classrooms');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }   
    public function student_psychology()
    {
        return $this->hasMany(student_psychology::class, 'classroom_id');
    }
    public function student_classroom()
    {
        return $this->hasMany(student_classroom::class, 'classroom_id');
    }
}
