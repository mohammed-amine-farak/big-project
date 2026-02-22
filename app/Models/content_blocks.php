<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class content_blocks extends Model
{
     public function rules(){
        return $this->belongsTo(rules::class, 'rule_id');
     }
}
