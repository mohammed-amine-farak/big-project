<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class study_year extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_name',
        'year_name_ar', 
        'is_active',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    // العلاقة مع الفصول الدراسية
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    // العلاقة مع الاختبارات الأسبوعية
    

    // الحصول على السنة الدراسية النشطة
    public static function getActiveYear()
    {
        return static::where('is_active', true)->first();
    }

    // التحقق إذا كانت السنة نشطة
    public function isActive()
    {
        return $this->is_active;
    }

    // الحصول على اسم السنة باللغة العربية
    public function getArabicName()
    {
        return $this->year_name_ar;
    }

}
