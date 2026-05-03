<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student_classroom extends Model
{
     protected $table = 'student_classrooms';
        protected $fillable = [
        'student_id',
        'classroom_id',
        'enrollment_date',
        'is_active'
    ];

   
public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
    
}
