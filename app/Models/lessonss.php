<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\rules;
class lessonss extends Model
{
    protected $table = 'lessonss';
    
    public function researcher()
    {
        // A Lesson belongs to a User who acts as a researcher.
        // The foreign key on 'lessonss' table is 'researcher_id'.
        return $this->belongsTo(User::class, 'researcher_id');
    }
    public function exams()   // ← singular, hasOne
{
    return $this->hasOne(exams::class, 'lesson_id');
}
    public function rules()
    {
        // A Lesson has many Rules.
        // The foreign key on 'rules' table is 'lessons_id'.
        return $this->hasMany(rules::class, 'lessons_id');
    }

    public function Interaction_Notes_students()
    {
       
        return $this->hasMany(Interaction_Notes_students::class, 'lesson_id');
    }
    public function subject()
    {
        // A Lesson belongs to a Subject.
        // The foreign key on 'lessonss' table is 'subject_id'.
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function lessonReports()
    {
        return $this->hasMany(lesson_report::class,'lesson_id');
    } 
 public function productionRequests()
    {
        return $this->hasMany(production_request::class, 'lesson_id');  // ✅ lesson_id وليس lessonss_id
    }
    protected $casts = [
        'completed_at' => 'datetime',
    ];

     public function examWeeckly()
    {
        return $this->hasOne(exam_weeckly::class, 'lesson_id');
    }
    // You might also want to cast summary_points if it's JSON
  
    // Fillable fields to allow mass-assignment
    protected $fillable = [
        'researcher_id',
        'title',
        'content',
        'subject_id',
        'completed_at',

    ];

    // =========================================================
    // 🔥 العلاقات الجديدة لتتبع التقدم
    // =========================================================

    /**
     * العلاقة مع تقدم الطلاب في هذا الدرس
     * Lesson has many student progress records
     */
    public function studentProgress()
    {
        return $this->hasMany(StudentLessonProgress::class, 'lesson_id');
    }

    /**
     * العلاقة مع تقدم الطلاب في كتل المحتوى لهذا الدرس
     * Lesson has many content progress records (through student progress)
     */
    public function studentContentProgress()
    {
        return $this->hasMany(StudentContentProgress::class, 'lesson_id');
    }

    /**
     * الحصول على تقدم طالب معين في هذا الدرس
     */
    public function getStudentProgress($studentId)
    {
        return $this->studentProgress()
            ->where('student_id', $studentId)
            ->first();
    }

    /**
     * حساب إجمالي كتل المحتوى في هذا الدرس
     */
    public function getTotalContentBlocksAttribute()
    {
        $total = 0;
        foreach ($this->rules as $rule) {
            $total += $rule->contentBlocks()->count();
        }
        return $total;
    }

    /**
     * حساب كتل المحتوى المكتملة لطالب معين
     */
    public function getCompletedContentBlocksForStudent($studentId)
    {
        return StudentContentProgress::where('student_id', $studentId)
            ->where('lesson_id', $this->id)
            ->where('completed', true)
            ->count();
    }

    /**
     * حساب نسبة تقدم طالب معين في هذا الدرس
     */
    public function getProgressPercentageForStudent($studentId)
    {
        $total = $this->total_content_blocks;
        if ($total == 0) return 0;
        
        $completed = $this->getCompletedContentBlocksForStudent($studentId);
        return round(($completed / $total) * 100);
    }




}
