<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class level_skill extends Model
{
    protected $fillable = [
        'skill_id',
        'level_name',
        'level_description', 
        'level',
        

    ];

    protected $table = 'level_skills';

    public function skill()
    {
        // A LevelSkill belongs to a Skill.
        // The foreign key on 'level_skills' table is 'skill_id'.
        return $this->belongsTo(Skills::class, 'skill_id');
    }
    public function examWeeklySkills()
    {
        return $this->hasMany(exams_weekly_skills::class, 'id_level');
    }



}
