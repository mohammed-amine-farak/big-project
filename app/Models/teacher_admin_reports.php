<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teacher_admin_reports extends Model
{
    protected $fillable = [
        'admin_id',
        'teacher_id',
        'title',
        'description',
        'report_type',
        'priority',
        'is_read',
        'deadline',
        'related_documents',
    ];
  public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Report belongs to one Teacher (receiver)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
