<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_type extends Model
{
    protected $fillable = [
        'name',
    ];
    
    protected $table="work_types";
    protected $primaryKey="work_id";

     public function experiences() {
        return $this -> hasMany('\App\Experience','work_id');
    }
}
