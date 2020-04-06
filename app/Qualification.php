<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
     protected $fillable = [
        'name',
    ];
    
    protected $table="qualifications";
    protected $primaryKey="qualificat_id";

}
