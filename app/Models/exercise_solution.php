<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class exercise_solution extends Model
{
        protected $table = 'exercise_solutions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_block_id',
        'solution_text',
        'hint',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the content block that owns the exercise solution.
     */
    public function contentBlock()
    {
        return $this->belongsTo(content_blocks::class, 'content_block_id');
    }
    
    /**
     * Get the solution text with preserved formatting.
     */
    public function getFormattedSolutionAttribute()
    {
        return nl2br(e($this->solution_text));
    }
    
    /**
     * Get the hint with preserved formatting.
     */
    public function getFormattedHintAttribute()
    {
        return $this->hint ? nl2br(e($this->hint)) : null;
    }
    
    /**
     * Check if solution has a hint.
     */
    public function hasHint()
    {
        return !empty($this->hint);
    }
}
