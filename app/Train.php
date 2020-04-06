<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $fillable = [
        'title','teacher_id', 'institute','countery_id','special_id','st_date','end_date','path',
    ];
    
    protected $table="trains";
    protected $primaryKey="train_id";

    public function teachers()
    {return $this->belongsTo('\App\Teacher','teacher_id');}

    public function countreis() {
    	return $this->belongsTo('\App\Countery','countery_id');
    }

     public function specials()
    {return $this->belongsTo('\App\Special','special_id');}

}
