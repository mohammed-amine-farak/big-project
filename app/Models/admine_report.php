<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admine_report extends Model
{
    public function admin()
    {
        return $this->belongsTo(admin::class);
    }
    public function researcher()
    {
        return $this->belongsTo(researchers::class);
    }
}
