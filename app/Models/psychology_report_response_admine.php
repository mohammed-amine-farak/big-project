<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class psychology_report_response_admine extends Model
{
     public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }   
    public function admin()
    {
        return $this->belongsTo(admin::class, 'admin_id');
    }
    public function student_psychologies()
    {
        return $this->belongsTo(student_psychology::class, 'student_psychology_id');
    }

}
