<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    public function user() // Defines the inverse of the One-to-One relationship
    {
        // Eloquent assumes 'user_id' foreign key on the current (Student) model's table.
        // If your foreign key is named differently, pass it as the second argument:
        // return $this->belongsTo(User::class, 'owner_id');
        return $this->belongsTo(User::class);
    }

    public function Interaction_Notes_students()
    {
        return $this->hasMany(Interaction_Notes_students::class, 'student_id');
    }
}
