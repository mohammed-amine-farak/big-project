<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class exams_weekly_skills extends Model
{
    protected $fillable = [
        'exams_weekly_id',
        'id_level',
        'status'
    ];
    public function examWeekly()
    {
        return $this->belongsTo(exam_weeckly::class, 'exams_weekly_id');
    }

    // Relationship with LevelSkill
    public function levelSkill()
    {
        return $this->belongsTo(level_skill::class, 'id_level');
    }

}
