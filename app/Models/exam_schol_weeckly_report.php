<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class exam_schol_weeckly_report extends Model
{
 protected $fillable = ['student_id', 'teacher_id', 'exam_weecklies_id', 'exam_total_point', 'exam_note'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * العلاقة مع المعلم (Teacher)
     * تقرير الامتحان ينتمي إلى معلم واحد
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * العلاقة مع الامتحان الأسبوعي (ExamWeeckly)
     * تقرير الامتحان ينتمي إلى امتحان أسبوعي واحد
     */
    public function examWeeckly()
    {
        return $this->belongsTo(exam_weeckly::class, 'exam_weecklies_id');
    }


}
