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
        
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject()
    {
      
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function weeklySkills()
    {
        return $this->hasMany(exams_weekly_skills::class, 'exams_weekly_id');
    }

}
