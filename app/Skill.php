<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name','teacher_id', 'decription',
    ];
    
    protected $table="skills";
    protected $primaryKey="skill_id";

    public function teachers()
    {return $this->belongsTo('\App\Teacher','teacher_id');}
    
}
