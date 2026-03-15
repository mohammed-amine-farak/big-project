<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class video_creator extends Model
{
    public $incrementing = false; // لأن المفتاح ليس auto-increment هنا
    protected $primaryKey = 'id';
  protected $fillable = [
        'id',
        'specialization',
        'skills',
        'portfolio_url',
        'preferred_software',
        'completed_videos',
        'average_rating',
        'total_ratings',
        'total_rating_sum',
        'status',
    ];

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
