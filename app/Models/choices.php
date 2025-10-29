<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class choices extends Model
{
    protected $fillable = ['choice_text', 'is_correct', 'question_id'];

    /**
     * Get the question that owns the choice.
     */
    public function question()
    {
        return $this->belongsTo(questions::class);
    }
}
