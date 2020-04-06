<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name', 'countery_id',
    ];
    
    protected $table="states";
    protected $primaryKey="state_id";

    public function countreis() {
    	return $this->belongsTo('\App\Countery','countery_id');
    }

    public function regionals() {
    	return $this -> hasMany('\App\Regional','state_id');
    }
     public function contacts()
    {
        return $this -> hasMany('\App\Contact','state_id');
    }
    public function conferences() {
        return $this -> hasMany('\App\Conference','state_id');
    }
}
