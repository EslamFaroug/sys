<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mangejob extends Model
{
   

	 protected $fillable = [
        'name',
    ];
    
    protected $table="mangejobs";
    protected $primaryKey="mangejob_id";

    public function teachers() {
        return $this -> hasMany('\App\Teacher','mangejob_id');
    }
    public function experiences() {
        return $this -> hasMany('\App\Experience','mangejob_id');
    }
    

}
