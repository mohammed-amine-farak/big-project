<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fields_Of_Study extends Model
{
    protected $table = 'fields_of_studies';

     protected $fillable = [
        'id',
        'name',
        'study_level',
        'description'
      ];
  
public function student(){
    return $this->hasMany(student::class, 'fields_id');
}

    public function subjects()
    {
        // A Field of Study has many Subjects.
        // The foreign key on 'subjects' table is 'fields_id'.
        return $this->hasMany(Subject::class, 'fields_id');
    }
}
