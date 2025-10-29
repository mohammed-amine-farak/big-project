<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class student_lesson_progresses extends Model
{
    use HasFactory;
    
protected $fillable = ['student_id', 'lesson_id', 'completion_percentage'];
}
