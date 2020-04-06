<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
	protected $fillable = [

    	'teacher_id','title','degree_id','publish_place','publish_date','supervisor_id','other_supervisor','research_file',

    ];

    protected $table="researches";
    protected $primaryKey="research_id";

    public function teachers(){
        return $this->belongsTo('\App\Teacher','teacher_id');
    }
    public function supervisor(){
        return $this->belongsTo('\App\Teacher','supervisor_id');
    }

    public function degrees(){
        return $this->belongsTo('\App\Degree','degree_id');
    }
}


