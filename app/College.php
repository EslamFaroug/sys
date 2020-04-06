<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $fillable = [
        'name', 'university_id',
    ];

    protected $table="colleges";
    protected $primaryKey="college_id";

    public function universities() {
    	return $this->belongsTo('\App\University','university_id');
    }
     public function departments() {
        return $this -> hasMany('\App\Department','college_id');
    }
     public function contacts()
        {
            return $this->hasMany('\App\Contact','college_id');
        }

        public function certificates() {
        return $this -> hasMany('\App\Certificate','college_id');
    }
      public function experiences() {
        return $this -> hasMany('\App\Experience','college_id');
    }
}
