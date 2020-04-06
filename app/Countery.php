<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countery extends Model
{
	protected $fillable = [
        'name', 'symbole',
    ];
    
    protected $table="counteries";
    protected $primaryKey="countery_id";



    public function states() {
    	return $this -> hasMany('\App\State','countery_id');
    }

	public function universities() {
    	return $this -> hasMany('\App\Univerity','countery_id');
    }

    public function teachers() {
        return $this -> hasMany('\App\Teacher','countery_id');
    }

    public function contacts()
    {
        return $this -> hasMany('\App\Contact','countery_id');
    }
    
    public function certificates() {
        return $this -> hasMany('\App\Certificate','countery_id');
    }
    public function trains(){
        return $this->hasMany('\App\Train','countery_id');
    }
    public function conferences() {
        return $this -> hasMany('\App\Conference','countery_id');
    }

     public function experiences() {
        return $this -> hasMany('\App\Experience','countery_id');
    }
}
