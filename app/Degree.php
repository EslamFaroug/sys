<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $fillable = [
        'name',
    ];
    
    protected $table="degrees";
    protected $primaryKey="degree_id";

    public function teachers() {
        return $this -> hasMany('\App\Teacher','degree_id');
    }

    public function certificates() {
        return $this -> hasMany('\App\Certificate','degree_id');
    }
    public function researches() {
        return $this -> hasMany('\App\Research','degree_id');
    }
    public function experiences() {
        return $this -> hasMany('\App\Experience','degree_id');
    }
}
