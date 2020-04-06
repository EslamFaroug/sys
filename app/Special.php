<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    
    protected $fillable = [
        'name','special_type', 'depart_id',
    ];
    
    protected $table="specials";
    protected $primaryKey="special_id";

    public function departments() {
    	return $this->belongsTo('\App\Department','depart_id');
    }
     public function contacts()
    {
        return $this -> hasMany('\App\Contact','special_id');
    }

    public function certificates() {
        return $this -> hasMany('\App\Certificate','special_id');
    }

     public function trains(){
        return $this->hasMany('\App\Train','special_id');
    }
      public function experiences() {
        return $this -> hasMany('\App\Experience','special_id');
    }
}
