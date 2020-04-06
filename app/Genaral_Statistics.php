<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genaral_Statistics extends Model
{
    public function countery() {
        return $this->belongsTo('\App\Countery','countery_id');
    }
    public function type() {
        return $this->belongsTo('\App\Type','type_id');
    }
    public function university() {
        return $this->belongsTo('\App\University','university_id');
    }
    public function college() {
        return $this->belongsTo('\App\College','college_id');
    }
    public function department() {
        return $this->belongsTo('\App\Department','depart_id');
    }
    public function special() {
        return $this->belongsTo(Special::class,'special_id');
    }
    public function degree() {
        return $this->belongsTo('\App\Degree','degree_id');
    }

}
