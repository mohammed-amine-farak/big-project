<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{ 
    
    public $incrementing = false; // لأن المفتاح ليس auto-increment هنا
    protected $primaryKey = 'id';
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function admin_report()
    {
        return $this->hasMany(admine_report::class);
    }
    public function psychology_report_response_admine(){
        return $this->hasMany(psychology_report_response_admine::class, 'admin_id');
     }
     public function reports()
{
    return $this->hasMany(teacher_admin_reports::class);
}

}
