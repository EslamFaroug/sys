<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $fillable = [

    	'teacher_id','title','publish_place','publis_date','volume_no','peper_file',
    	       
    ];
    
    protected $table="papers";
    protected $primaryKey="paper_id";

    public function teachers()
    {return $this->belongsTo('\App\Teacher','teacher_id');}

}
