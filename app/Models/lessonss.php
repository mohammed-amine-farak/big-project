<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\rules;
class lessonss extends Model
{
    protected $table = 'lessonss';
    
    public function researcher()
    {
        // A Lesson belongs to a User who acts as a researcher.
        // The foreign key on 'lessonss' table is 'researcher_id'.
        return $this->belongsTo(User::class, 'researcher_id');
    }
    public function exams()
    {
        return $this->hasMany(exams::class, 'lesson_id');
    }
    public function rules()
    {
        // A Lesson has many Rules.
        // The foreign key on 'rules' table is 'lessons_id'.
        return $this->hasMany(rules::class, 'lessons_id');
    }

    public function Interaction_Notes_students()
    {
       
        return $this->hasMany(Interaction_Notes_students::class, 'lesson_id');
    }
    public function subject()
    {
        // A Lesson belongs to a Subject.
        // The foreign key on 'lessonss' table is 'subject_id'.
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function lessonReports()
    {
        return $this->hasMany(lesson_report::class);
    } 


    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // You might also want to cast summary_points if it's JSON
  
    // Fillable fields to allow mass-assignment
    protected $fillable = [
        'researcher_id',
        'title',
        'content',
        'subject_id',
        'completed_at',

    ];
}
