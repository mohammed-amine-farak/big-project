<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class school extends Model
{
    public function classroom(){
        return $this->hasMany(classroom::class);
    }
}
