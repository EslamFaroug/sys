<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
     protected $fillable = [
        'name', 'state_id',
    ];
    
    protected $table="regionals";
    protected $primaryKey="regional_id";

    public function states() {
    	return $this->belongsTo('\App\State','state_id');
    }

    public function units() {
    	return $this -> hasMany('\App\Unit','regional_id');
    }
     public function contacts()
    {
        return $this -> hasMany('\App\Contact','regional_id');
    }
}
