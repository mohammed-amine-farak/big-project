<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class production_request extends Model
{
   

    protected $table = 'production_requests';



    protected $fillable = [
        'researcher_id',
        'video_creator_id',
        'lesson_id',
        'rule_id',
        'content_block_id',
        'title',
        'description',
        'reference_file',
        'reference_file_path',
        'deadline',
        'status',
        'accepted_at',
        'submitted_at',
        'approved_at',
        'revision_details',
        'notes',
       
    ];

    protected $casts = [
        'deadline' => 'date',
        'accepted_at' => 'datetime',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime'
    ];

    // =========================================================
    // 🔗 العلاقات (Relationships)
    // =========================================================

    /**
     * العلاقة مع الباحث (صاحب الطلب)
     * ProductionRequest belongs to Researcher
     */
    public function researcher()
    {
        return $this->belongsTo(Researchers::class);
    }

    /**
     * العلاقة مع منشئ الفيديو (المنفذ)
     * ProductionRequest belongs to VideoCreator
     */
    public function videoCreator()
    {
        return $this->belongsTo(video_creator::class);
    }

    /**
     * العلاقة مع الدرس
     * ProductionRequest belongs to Lesson
     */
    public function lesson()
    {
        return $this->belongsTo(lessonss::class, 'lesson_id');
    }

    /**
     * العلاقة مع القاعدة (اختياري)
     * ProductionRequest belongs to Rule
     */
    public function rule()
    {
        return $this->belongsTo(rules::class);
    }

    /**
     * العلاقة مع كتلة المحتوى (اختياري)
     * ProductionRequest belongs to ContentBlock
     */
    public function contentBlock()
    {
        return $this->belongsTo(content_blocks::class);
    }

    /**
     * العلاقة مع الفيديوهات المنتجة لهذا الطلب
     * ProductionRequest has many Videos
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'production_request_id');
    }

    /**
     * أحدث فيديو لهذا الطلب
     */
    public function latestVideo()
    {
        return $this->hasOne(Video::class, 'production_request_id')->latestOfMany();
    }

    /**
     * أول فيديو لهذا الطلب
     */
    public function oldestVideo()
    {
        return $this->hasOne(Video::class, 'production_request_id')->oldestOfMany();
    }

    /**
     * الفيديوهات المقبولة فقط
     */
    public function approvedVideos()
    {
        return $this->hasMany(Video::class, 'production_request_id')
                    ->where('status', 'approved');
    }

    /**
     * الفيديوهات قيد المراجعة
     */
    public function pendingVideos()
    {
        return $this->hasMany(Video::class, 'production_request_id')
                    ->where('status', 'under_review');
    }
}