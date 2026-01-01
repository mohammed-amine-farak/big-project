<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_psychology extends Model
{
   protected $fillable = ['student_id', 'classroom_id', 'teacher_id','mood','social_interaction','concentration','participation','behavior','strengths','challenges','recommendations','general_notes','teacher_note','status'];
   
   public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function psychology_report_response_admine()
    {
        return $this->hasMany(psychology_report_response_admine::class, 'student_psychology_id');
    }
}
