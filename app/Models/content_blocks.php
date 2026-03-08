<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class content_blocks extends Model
{
    protected $fillable = [
        'rule_id',
        'type',
        'content',
        'block_order',
        
    ];

     public function rules(){
        return $this->belongsTo(rules::class, 'rule_id');
     }
     public function productionRequests()
    {
        return $this->belongsTo(production_request::class,'content_block_id');
    }
    public function video()
    {
        return $this->hasOne(Video::class, 'content_block_id');
    }
    
}
