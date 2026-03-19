<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class exam_weeckly extends Model
{
   
    protected $fillable = [
        'researcher_id',
        'title',
        'file_path',
        'subject_id',
        'classroom_id',
        'lesson_id'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject()
    {
      
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function researcher()
    {
        return $this->belongsTo(Researchers::class, 'researcher_id');
    }
    public function weeklySkills()
    {
        return $this->hasMany(exams_weekly_skills::class, 'exams_weekly_id');
    }

    public function exam_schol_weeckly_report(){
        return $this->hasMany(exam_schol_weeckly_report::class, 'exam_weecklies_id');
    }
    public function lesson(){
        return $this->belongsTo(lessonss::class, 'lesson_id');
    }
}
