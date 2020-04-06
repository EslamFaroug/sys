<?php

namespace App\Http\Controllers;

use App\Interest;
use App\Degree;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterestsReportsController extends Controller
{
    public function index(){
        $universities  = University::all();
        $degrees=Degree::all();
        $interests=DB::table("interests")
            ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
            ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
            ->join("counteries","contacts.countery_id","=","counteries.countery_id")
            ->join("specials","specials.special_id","=","contacts.special_id")
            ->join("universities","universities.university_id","=","contacts.university_id")
            ->select('interests.*',
                'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                'counteries.name as countery', 'universities.name as university',
                'specials.name as special'
            )->get();
        return view('re_interests.index', compact(['interests','universities','degrees']));


    }

    public function resultInterest(Request $request)
    {
        $html= view('re_interests.row',['interests'=>$this->queries($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }
    private  function queries($request){
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $interests=Interest::all();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $interests=DB::table("interests")
                ->join("teachers","teachers.teacher_id","=","interests.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("specials","specials.special_id","=","contacts.special_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->select('interests.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'specials.name as special'
                )
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        return $interests;
    }

    public function printInterest($id=null)
    {
        return view('re_interests.interest')
            ->with('teacher',Teacher::find(Interest::find($id)->teacher_id));
    }

    public function viewInterest($id=null)
    {
        return view('re_interests.interestView')
            ->with('teacher',Teacher::find(Interest::find($id)->teacher_id));
    }


    public function printInterests(Request $request)
    {
       $interests=$this->queries($request);
        return view('re_interests.interests',compact("interests","request"));

    }
}
