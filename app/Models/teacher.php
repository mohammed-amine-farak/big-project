<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    public $incrementing = false; // لأن المفتاح ليس auto-increment هنا
    protected $primaryKey = 'id';

    public function Interaction_Notes_students()
    {
        // A single teacher can have many notes, so hasMany is the correct relationship.
        return $this->hasMany(Interaction_Notes_students::class, 'teacher_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function lessonReports()
    {
        return $this->hasMany(lesson_report::class);
    }
}
