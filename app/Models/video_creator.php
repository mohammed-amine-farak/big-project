<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class video_creator extends Model
{
    public function productionRequests()
    {
        return $this->hasMany(production_request::class);
    }
}
