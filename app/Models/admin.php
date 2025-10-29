<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{ public $incrementing = false; // لأن المفتاح ليس auto-increment هنا
    protected $primaryKey = 'id';
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function admin_report()
    {
        return $this->hasMany(admine_report::class);
    }
}
