<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study_type extends Model
{
    protected $fillable = [
        'name',
    ];
    
    protected $table="study_types";
    protected $primaryKey="study_id";
}
