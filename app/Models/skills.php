<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class skills extends Model
{
    public function levelSkills()
    {
        return $this->hasMany(level_skill::class, 'skill_id');
    }

    public function subject()
    {
        // A Lesson belongs to a Subject.
        // The foreign key on 'lessonss' table is 'subject_id'.
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    protected $fillable = ['name', 'description', 'subject_id'];
}
