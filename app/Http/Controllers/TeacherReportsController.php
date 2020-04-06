<?php

namespace App\Http\Controllers;

use App\Countery;
use App\Degree;
use App\University;
use Illuminate\Http\Request;
use \App\Auth;
use \App\User;
use \App\Teacher;
use \App\Certificate;
use \App\Contact;
use \App\Interest;
use \App\Department;
use Illuminate\Support\Facades\DB;

class TeacherReportsController extends Controller
{
     public function index($id=null)
    {
        if($id == null)
        {
             $universities  = University::all();
            $teachers=Teacher::all();
            $degrees=Degree::all();
            return view('re_teachers.all_teachers' , compact(['teachers','universities','degrees']));
        }

    }
    public function viewTeacher($id)
    {
    	return view('re_teachers.tr_data')
    	->with('teacher',Teacher::find($id));
    }


    public function resultTeacher(Request $request)
    {
         if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                  ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $teachers=Teacher::all();
         }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%');
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->unionAll($first)
                 ->get();
          }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and !$request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.college_id','=',$request->college_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and !$request->university_id and !$request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.depart_id','=',$request->depart_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and $request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.special_id','=',$request->special_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->unionAll($first)
                 ->get();
         }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
         }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->get();
         }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->get();
         }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
         }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->get();
         }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
         }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->get();
         }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
         }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->get();
         }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
         }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $teachers=DB::table("teachers")
                 ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                 ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
         }
        $html= view('re_teachers.index',['teachers'=>$teachers])->render();
        return response(['status'=>true,'result'=>$html]);
    }

    public function printTeacher($id=null)
    {
        return view('re_teachers.teacher')
            ->with('teacher',Teacher::find($id));
    }
    public function printTeachers(Request $request)
    {
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $teachers=Teacher::all();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.college_id','=',$request->college_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.depart_id','=',$request->depart_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.special_id','=',$request->special_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $teachers=DB::table("teachers")
                ->join("counteries","teachers.countery_id","=","counteries.countery_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','counteries.name as countery', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        return view('re_teachers.teachers',compact("teachers","request"));
    }


}
