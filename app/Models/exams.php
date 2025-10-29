<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class exams extends Model
{
    protected $fillable = ['title', 'subject', 'start_time', 'end_time', 'researcher_id', 'lesson_id'];

    /**
     * Get the questions for the exam.
     */
    public function questions()
    {
        return $this->hasMany(questions::class,'exam_id');
    }

    /**
     * Get the researcher who created the exam.
     */
    public function researcher()
    {
        return $this->belongsTo(researchers::class);
    }

    /**
     * Get the lesson this exam belongs to.
     */
    public function lesson()
    {
        // Make sure this matches your database column name
        return $this->belongsTo(lessonss::class, 'lesson_id');
    }

}
