<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rules extends Model
{
    

    // The foreign key on 'rules' table that links back to lessons.
    public function lesson()
    {
        return $this->belongsTo(Lessonss::class, 'lessons_id');
    }



    public function examples()
    {
        // A Rule has many RuleExamples.
        // Tell Eloquent that the foreign key on the 'rule_examples' table is 'rules_id'.
        return $this->hasMany(rule_examples::class, 'rule_id'); // <--- Specify the foreign key
    
}


protected $fillable = [
     'lessons_id',
    'title',
    'description' ,
   
    
];
      
}