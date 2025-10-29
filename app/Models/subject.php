<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    protected $table = 'subjects';

    public function skill()
    {
        
        return $this->hasMany(skills::class, 'subject_id');
    }
    

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_subject');
    }

    public function lessons()
    {
        // A Subject has many Lessons.
        // The foreign key on 'lessonss' table is 'subject_id'.
        return $this->hasMany(lessonss::class, 'subject_id');
    }
    public function exam_weecklies(){
        return $this->hasMany(exam_weeckly::class, 'subject_id');

    }




    public function fieldOfStudy()
    {
        // A Subject belongs to a Field of Study.
        // The foreign key on 'subjects' table is 'fields_id'.
        return $this->belongsTo(Fields_Of_Study::class, 'fields_id');
    }
}
