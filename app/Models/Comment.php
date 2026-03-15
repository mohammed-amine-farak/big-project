<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'user_id',
        'content',
        'parent_id',
        'is_approved',
        'read_at',
        'likes_count'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'read_at' => 'datetime',
        'likes_count' => 'integer'
    ];

    /**
     * ✅ العلاقة متعددة الأشكال - الموديل القابل للتعليق (Video, Lesson, ProductionRequest)
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * ✅ العلاقة مع المستخدم (صاحب التعليق)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ✅ العلاقة مع الردود (جميع الردود على هذا التعليق)
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->orderBy('created_at', 'asc');
    }

    /**
     * ✅ العلاقة مع التعليق الأصلي (إذا كان هذا رداً)
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * ✅ الردود المقبولة فقط
     */
    public function approvedReplies()
    {
        return $this->replies()->where('is_approved', true);
    }

    /**
     * ✅ هل هذا تعليق أصلي؟
     */
    public function isParent()
    {
        return is_null($this->parent_id);
    }

    /**
     * ✅ هل هذا رد؟
     */
    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    /**
     * ✅ هل لديه ردود؟
     */
    public function hasReplies()
    {
        return $this->replies()->count() > 0;
    }

    /**
     * ✅ تحديث حالة القراءة
     */
    public function markAsRead()
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
            return true;
        }
        return false;
    }

    /**
     * ✅ الموافقة على التعليق
     */
    public function approve()
    {
        $this->update(['is_approved' => true]);
    }

    /**
     * ✅ رفض التعليق
     */
    public function reject()
    {
        $this->update(['is_approved' => false]);
    }

    /**
     * ✅ زيادة عدد الإعجابات
     */
    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    /**
     * ✅ إنقاص عدد الإعجابات
     */
    public function decrementLikes()
    {
        if ($this->likes_count > 0) {
            $this->decrement('likes_count');
        }
    }

    /**
     * ✅ الحصول على عمق التعليق (للهيكل الشجري)
     */
    public function getDepthAttribute()
    {
        $depth = 0;
        $comment = $this;
        
        while ($comment->parent) {
            $depth++;
            $comment = $comment->parent;
        }
        
        return $depth;
    }

    /**
     * ✅ الحصول على جميع الردود بشكل متكرر (للهيكل الشجري)
     */
    public function allReplies()
    {
        return $this->replies()->with('allReplies');
    }

    // =========================================================
    // Scopes
    // =========================================================

    /**
     * ✅ Scope: التعليقات الأصلية فقط (ليست ردود)
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * ✅ Scope: الردود فقط
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * ✅ Scope: التعليقات غير المقروءة
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * ✅ Scope: التعليقات المقروءة
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * ✅ Scope: التعليقات المقبولة
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * ✅ Scope: التعليقات المعلقة (غير مقبولة)
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * ✅ Scope: ترتيب حسب الأحدث
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * ✅ Scope: ترتيب حسب الأكثر إعجاباً
     */
    public function scopeMostLiked($query)
    {
        return $query->orderBy('likes_count', 'desc');
    }
}