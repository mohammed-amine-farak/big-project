<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admine_report extends Model
{
    protected  $fillable = [
        'admin_id',
        'researcher_id',
        'report_title',
        'report_content',
        'researcher_response',
        'report_type',
        'priority',
        'status',
        'deadline',
    
    ];
    public function admin()
    {
        return $this->belongsTo(admin::class);
    }
    public function researcher()
    {
        return $this->belongsTo(researchers::class);
    }
}
