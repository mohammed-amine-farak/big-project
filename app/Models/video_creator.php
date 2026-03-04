<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class video_creator extends Model
{
    public $incrementing = false; // لأن المفتاح ليس auto-increment هنا
    protected $primaryKey = 'id';


    public function productionRequests()
    {
        return $this->hasMany(production_request::class);
    }
    public function user() 
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function video(){
         return $this->hasMany(video::class);
    }
}
