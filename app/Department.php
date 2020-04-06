<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    
    protected $fillable = [
        'name', 'college_id',
    ];
    
    protected $table="departments";
    protected $primaryKey="depart_id";

    public function colleges() {
    	return $this->belongsTo('\App\College','college_id');
    }

    public function specials() {
        return $this -> hasMany('\App\Special','depart_id');
    }
       public function contacts()
        {
         return $this -> hasMany('\App\Contact','depart_id');
        }

        public function certificates() {
        return $this -> hasMany('\App\Certificate','depart_id');
    }
      public function experiences() {
        return $this -> hasMany('\App\Experience','depart_id');
    }
    
}
