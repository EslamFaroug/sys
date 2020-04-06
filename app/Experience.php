<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
     protected $fillable = [
        'exp_name','teacher_id','degree_id','mangejob_id','institute', 'countery_id','university_id','college_id','depart_id','special_id','work_id','type_id','work_place_2','start_date','end_date','decrip',
    ];
    
    protected $table="experiences";
    protected $primaryKey="exp_id";

    public function teachers(){
        return $this->belongsTo('\App\Teacher','teacher_id');
    }
    public function degrees(){
        return $this->belongsTo('\App\Degree','degree_id');
    }
     public function mangejobs(){
        return $this->belongsTo('\App\Mangejob','mangejob_id');
    }

    public function countreis() {
    	return $this->belongsTo('\App\Countery','countery_id');
    }
    public function universities() {
    	return $this->belongsTo('\App\University','university_id');
    }
     public function colleges() {
    	return $this->belongsTo('\App\College','college_id');
    }
    public function departments() {
    	return $this->belongsTo('\App\Department','depart_id');
    }
     public function specials() {
     	return $this->belongsTo('\App\Special','special_id');
     }
   
	public function work_types() {
     	return $this->belongsTo('\App\Work_type','work_id');
     }
     public function types() {
     	return $this->belongsTo('\App\Type','type_id');
     }
    
}
