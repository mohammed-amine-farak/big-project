<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class exam_schol_weeckly_report extends Model
{
 protected $fillable = ['student_id', 'teacher_id', 'exam_weecklies_id', 'exam_total_point', 'exam_note'];
}
