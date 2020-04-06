<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
     protected $fillable = [
        'name', 'regional_id',
    ];
    
    protected $table="units";
    protected $primaryKey="unit_id";

    public function regionals() {
    	return $this->belongsTo('\App\Regional','regional_id');
    }
     public function contacts()
    {
        return $this -> hasMany('\App\Contact','unit_id');
    }
}
