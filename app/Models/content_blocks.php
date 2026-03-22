<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class content_blocks extends Model
{
    protected $fillable = [
        'rule_id',
        'type',
        'content',
        'block_order',
        
    ];

     public function rules(){
        return $this->belongsTo(rules::class, 'rule_id');
     }
     public function productionRequests()
    {
        return $this->belongsTo(production_request::class,'content_block_id');
    }
    public function video()
    {
        return $this->hasOne(Video::class, 'content_block_id');
    }
        public function studentProgress()
    {
        return $this->hasMany(StudentContentProgress::class, 'content_block_id');
    }

    /**
     * الحصول على تقدم طالب معين في هذه الكتلة
     */
    public function getStudentProgress($studentId)
    {
        return $this->studentProgress()
            ->where('student_id', $studentId)
            ->first();
    }

    /**
     * التحقق مما إذا كان طالب معين قد أكمل هذه الكتلة
     */
    public function isCompletedByStudent($studentId)
    {
        $progress = $this->getStudentProgress($studentId);
        return $progress ? $progress->completed : false;
    }

    /**
     * التحقق مما إذا كان طالب معين قد شاهد هذه الكتلة
     */
    public function isViewedByStudent($studentId)
    {
        $progress = $this->getStudentProgress($studentId);
        return $progress ? $progress->viewed : false;
    }

    /**
     * تحديد وزن الكتلة في حساب التقدم (يمكن تخصيصه حسب النوع)
     */
    public function getWeightAttribute()
    {
        switch ($this->type) {
            case 'video':
                return 30; // الفيديو له وزن أكبر
            case 'exercise':
                return 30; // التمارين مهمة
            case 'math':
                return 20; // المعادلات
            case 'text':
                return 15; // النصوص
            case 'image':
                return 5;  // الصور
            default:
                return 10;
        }
    }
    public function exerciseSolution()
{
    return $this->hasOne(exercise_solution::class, 'content_block_id');
}
}
