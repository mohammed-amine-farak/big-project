<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Commentable;
class video extends Model
{
    use Commentable;
     protected $fillable = [
        'creator_id',
        'production_request_id',
        'title',
        'description',
        'file_path',
        'thumbnail',
        'duration',
        'video_format',
        'file_size',
        'views',
        'likes',
        'completion_rate'
    ];

    public function productionRequests()
    {
        return $this->belongsTo(Video::class, 'production_request_id');
    }
      public function creator()
    {
        return $this->belongsTo(video_creator::class, 'creator_id');
    }
public function contentBlock()
    {
        return $this->belongsTo(content_blocks::class, 'content_block_id');
    }
}
