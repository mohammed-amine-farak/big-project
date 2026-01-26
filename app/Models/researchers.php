<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Researchers extends Model
{
    protected $primaryKey = 'id'; // If researcher ID is also user ID
    protected $table = 'researchers'; // Explicitly define the table name

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function lessonReports()
    {
        return $this->hasMany(lesson_report::class);
    }
   public function exam_weecly()
    {
        return $this->hasMany(exam_weeckly::class);
    }
    
    public function adminReport()
    {
        return $this->hasMany(admine_report::class);
    }
}
