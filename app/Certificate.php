<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
     protected $fillable = [
        'teacher_id',
        'degree_id',
        'cert_name',
        'university_id',
        'college_id',
        'depart_id',
        'special_id',
        'countery_id',
        'study_id',
        'cert_date',
        'sert_grade',
        'cert_image',
       
    ];
    
    protected $table="certificates";
    protected $primaryKey="cert_id";

    public function teachers()
    {return $this->belongsTo('\App\Teacher','teacher_id');}
    
    public function countreis()
    {return $this->belongsTo('\App\Countery','countery_id');}

    
    public function universities()
    {return $this->belongsTo('\App\University','university_id');}

    public function colleges()
    {return $this->belongsTo('\App\College','college_id');}

    public function departments()
    {return $this->belongsTo('\App\Department','depart_id');}

    public function specials()
    {return $this->belongsTo('\App\Special','special_id');}

     public function degrees() {
    	return $this->belongsTo('\App\Degree','degree_id');
    }

    public function studes(){
        return $this->belongsTo('\App\Study_type','study_id');
    }
}
