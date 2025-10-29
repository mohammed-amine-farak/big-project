<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classroom extends Model
{
    public function examWeeklies()
    {
        return $this->hasMany(exam_weeckly::class);
    }  
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classroom_subject');
    }
}
