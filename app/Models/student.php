<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $table = 'students';
    public $incrementing = false; // لأن المفتاح ليس auto-increment هنا
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',           // This is the foreign key to users table
        'fields_id',     // Foreign key to fields_of_studies table
        'school_level',
        'birth_date',
        'certificate_path',
        'transcript_path',
         'father_name',
        'father_job',
        'father_phone',
        'father_email',
        'mother_name',
        'mother_job',
        'mother_phone',
        'mother_email',
        'parent_address',
        'family_situation',
        'number_of_siblings'
        
    ];
    public function user() // Defines the inverse of the One-to-One relationship
    {
        // Eloquent assumes 'user_id' foreign key on the current (Student) model's table.
        // If your foreign key is named differently, pass it as the second argument:
        // return $this->belongsTo(User::class, 'owner_id');
        return $this->belongsTo(User::class,'id','id');
    }
    public function fieldStudy()
    {
        return $this->belongsTo(Fields_Of_Study::class, 'fields_id');
    }

    public function Interaction_Notes_students()
    {
        return $this->hasMany(Interaction_Notes_students::class, 'student_id');
    }
    public function student_psychology()
    {
        return $this->hasMany(student_psychology::class, 'student_id');
    }   
    public function student_classroom()
    {
        return $this->belongsToMany(student_classroom::class, 'student_classrooms');
    }
    public function exam_schol_weeckly_reports()
    {
        return $this->hasMany(exam_schol_weeckly_report::class, 'student_id');
    }
    
    
public function lessonProgress()
    {
        return $this->hasMany(StudentLessonProgress::class, 'student_id');
    }

    /**
     * العلاقة مع تقدم كتل المحتوى (جديد)
     * Student has many content progress records
     */
    public function contentProgress()
    {
        return $this->hasMany(StudentContentProgress::class, 'student_id');
    }

    /**
     * الحصول على تقدم درس معين (جديد)
     */
    public function getLessonProgress($lessonId)
    {
        return $this->lessonProgress()
            ->where('lesson_id', $lessonId)
            ->first();
    }

    /**
     * الحصول على تقدم كتلة محتوى معينة (جديد)
     */
    public function getContentProgress($contentBlockId)
    {
        return $this->contentProgress()
            ->where('content_block_id', $contentBlockId)
            ->first();
    }

    /**
     * حساب إجمالي تقدم الطالب في جميع الدروس (جديد)
     */
    public function getOverallProgressAttribute()
    {
        $totalLessons = lessonss::count();
        if ($totalLessons == 0) return 0;
        
        $completedLessons = $this->lessonProgress()
            ->where('completed', true)
            ->count();
            
        return round(($completedLessons / $totalLessons) * 100);
    }
    

}
