<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
     protected $fillable = [
        'name','teacher_id', 'countery_id','state_id','conf_date','participant',
    ];
    
    protected $table="conferences";
    protected $primaryKey="conf_id";

    public function teachers(){
        return $this->belongsTo('\App\Teacher','teacher_id');
    }

    public function countreis() {
    	return $this->belongsTo('\App\Countery','countery_id');
    }

    public function states() {
    	return $this->belongsTo('\App\State','state_id');
    }
}
