<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'teacher_id',
        'email',
        'mobile_no',
        'tel_no',
        'home_no',
        'tr_web',
        'university_id',
        'college_id',
        'depart_id',
        'special_id',
        'countery_id',
        'state_id',
        'regional_id',
        'unit_id',
    ];
    
    protected $table="contacts";
    protected $primaryKey="contact_id";

    public function teachers()
    {return $this->belongsTo('\App\Teacher','teacher_id');}
    
    public function countreis()
    {return $this->belongsTo('\App\Countery','countery_id');}

    public function states()
    {return $this->belongsTo('\App\State','state_id');}

    public function regionals()
    {return $this->belongsTo('\App\Regional','regional_id');}

    public function units()
    {return $this->belongsTo('\App\Unit','unit_id');}

    public function universities()
    {return $this->belongsTo('\App\University','university_id');}

    public function colleges()
    {return $this->belongsTo('\App\College','college_id');}

    public function departments()
    {return $this->belongsTo('\App\Department','depart_id');}

    public function specials()
    {return $this->belongsTo('\App\Special','special_id');}

}
