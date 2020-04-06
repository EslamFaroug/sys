<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'name', 'type_id', 'countery_id',
    ];
    
    protected $table="universities";
    protected $primaryKey="university_id";

    
    public function types() {
    	return $this->belongsTo('\App\Type','type_id');
    }

    public function countreis() {
    	return $this->belongsTo('\App\Countery','countery_id');
    }

    public function colleges() {
        return $this -> hasMany('\App\College','university_id');
    }
    public function contacts()
    {
        return $this -> hasMany('\App\Contact','university_id');
    }

    public function certificates() {
        return $this -> hasMany('\App\Certificate','university_id');
    }
      public function experiences() {
        return $this -> hasMany('\App\Experience','university_id');
    }
}
