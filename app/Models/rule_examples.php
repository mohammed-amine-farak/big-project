<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rule_examples extends Model
{
    protected $table = 'rule_examples'; // <--- ADD OR CORRECT THIS LINE

    // The foreign key on 'rule_examples' table that links back to 'rules'.
    // Your error indicates the column is named 'rules_id', not 'rule_id'.
    public function rule()
    {
        return $this->belongsTo(rules::class,'rule_id'); 
}
protected $fillable = [
    'rule_id',              // Important: This connects the example to its parent rule
    'example_title',
    'example_text',
    'example_description',
    'image_url',
    'image_alt_ar',         // For accessibility/SEO for the image
    'image_caption_ar',     // Caption for the image
];

}