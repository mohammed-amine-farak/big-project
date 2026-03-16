<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class video_creator extends Model
{
    protected $table = 'video_creators';
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
        'profile_image',
        'bio'
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
    protected $casts = [
        'skills' => 'array',
        'completed_videos' => 'integer',
        'average_rating' => 'float',
        'total_ratings' => 'integer',
        'total_rating_sum' => 'integer',
    ];

    protected $attributes = [
        'completed_videos' => 0,
        'average_rating' => 0,
        'total_ratings' => 0,
        'total_rating_sum' => 0,
        'status' => 'active',
    ];
}
