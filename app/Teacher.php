<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    
    protected $fillable = [

    	       'ar_name','en_name','card_id','dob','pod','gender','status','mother_tounge','national_id',
    	       
    ];
    
    protected $table="teachers";
    protected $primaryKey="teacher_id";

    public function countreis() {
    	return $this->belongsTo('\App\Countery','countery_id');
    }
    
    public function degrees() {
    	return $this->belongsTo('\App\Degree','degree_id');
    }

    public function contacts() {
        return $this -> hasMany('\App\Contact','teacher_id');
    }

    public function certificates() {
        return $this -> hasMany('\App\Certificate','teacher_id');
    }

    public function skills(){
        return $this->hasMany('\App\Skill','teacher_id');
    }
    
    public function trains(){
        return $this->hasMany('\App\Train','teacher_id');
    }

    public function papers(){
        return $this->hasMany('\App\Paper','teacher_id');
    }

     public function researches(){
        return $this->hasMany('\App\Research','teacher_id');
    }

     public function books(){
        return $this->hasMany('\App\Book','teacher_id');
    }
      public function interests(){
        return $this->hasMany('\App\Interest','teacher_id');
    }
     public function conferences() {
        return $this -> hasMany('\App\Conference','teacher_id');
    }
    public function experiences() {
        return $this -> hasMany('\App\Experience','teacher_id');
    }

    public function user() {
        return $this->belongsTo(\App\User::class,'user_id');
    }
}
