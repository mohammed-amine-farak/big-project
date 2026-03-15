<?php

namespace App\Traits;

use App\Models\Comment;

trait Commentable
{
    /**
     * ✅ العلاقة متعددة الأشكال مع التعليقات
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * ✅ التعليقات الأصلية فقط (ليست ردود)
     */
    public function parentComments()
    {
        return $this->morphMany(Comment::class, 'commentable')
                    ->whereNull('parent_id');
    }

    /**
     * ✅ التعليقات المقبولة فقط
     */
    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')
                    ->where('is_approved', true);
    }

    /**
     * ✅ التعليقات مع الردود (للشجرة الكاملة)
     */
    public function commentsWithReplies()
    {
        return $this->morphMany(Comment::class, 'commentable')
                    ->with('replies');
    }

    /**
     * ✅ عدد التعليقات
     */
    public function commentsCount()
    {
        return $this->morphMany(Comment::class, 'commentable')->count();
    }

    /**
     * ✅ إضافة تعليق جديد
     */
    public function addComment($content, $user, $parentId = null)
    {
        return $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content,
            'parent_id' => $parentId,
            'is_approved' => true // يمكن تغييرها حسب السياسة
        ]);
    }

    /**
     * ✅ إضافة رد على تعليق
     */
    public function addReply($content, $user, Comment $parentComment)
    {
        return $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content,
            'parent_id' => $parentComment->id,
            'is_approved' => true
        ]);
    }

    /**
     * ✅ جلب التعليقات مع الردود بشكل متكرر
     */
    public function threadedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')
                    ->whereNull('parent_id')
                    ->with('replies.user')
                    ->orderBy('created_at', 'desc');
    }
}