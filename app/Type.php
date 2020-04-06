<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    
	protected $fillable = [
        'name',
    ];
    
    protected $table="types";
    protected $primaryKey="type_id";



    public function universities() {
    	return $this -> hasMany('\App\University','type_id');
    }

     public function experiences() {
        return $this -> hasMany('\App\Experience','type_id');
    }
}
