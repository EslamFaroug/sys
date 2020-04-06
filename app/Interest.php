<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
     protected $fillable = [

    	'teacher_id','title','descrip',
    	       
    ];
    
    protected $table="interests";
    protected $primaryKey="interest_id";

    public function teachers()
    {return $this->belongsTo('\App\Teacher','teacher_id');}
}
