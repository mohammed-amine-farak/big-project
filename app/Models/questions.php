<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class questions extends Model
{
    protected $fillable = ['question_text', 'exam_id'];

    /**
     * Get the exam that owns the question.
     */
    public function exam()
    {
        return $this->belongsTo(exams::class);
    }

    /**
     * Get the choices for the question.
     */
    public function choices()
    {
        return $this->hasMany(choices::class,'question_id');
    }
}
