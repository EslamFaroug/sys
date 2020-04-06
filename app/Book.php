<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [

    	'teacher_id','title','isbn','publisher','f_edition','l_edition','book_file',
    	       
    ];
    
    protected $table="books";
    protected $primaryKey="book_id";

    public function teachers()
    {return $this->belongsTo('\App\Teacher','teacher_id');}
}
