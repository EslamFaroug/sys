<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Degree;
use App\Skill;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkillReportsController extends Controller
{
    public function index(){
        $universities  = University::all();
        $degrees=Degree::all();
        $skills=DB::table("skills")->distinct()
            ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
            ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
            ->join("counteries","contacts.countery_id","=","counteries.countery_id")
            ->join("universities","universities.university_id","=","contacts.university_id")
            ->join("colleges","colleges.college_id","=","contacts.college_id")
            ->select('skills.*',
                'teachers.en_name as teacher_en_name',
                'teachers.ar_name as teacher_ar_name'
                ,'counteries.name as countery', 'universities.name as university'
                , 'colleges.name as college')
            ->get();
        return view('re_skills.index', compact(['skills','universities','degrees']));

    }

    public function resultSkill(Request $request)
    {

        $html= view('re_skills.row',['skills'=>$this->Query($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }
    private function Query($request){
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $skills=DB::table("skills")->distinct()
                ->join("teachers","teachers.teacher_id","=","skills.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('skills.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name'
                    ,'counteries.name as countery', 'universities.name as university'
                    , 'colleges.name as college')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        return $skills;
    }

    public function printSkill($id=null)
    {
        return view('re_skills.skill')
            ->with('teacher',Teacher::find(Skill::find($id)->teacher_id));
    }

    public function viewSkill($id=null)
    {
        return view('re_skills.skillView')
            ->with('teacher',Teacher::find(Skill::find($id)->teacher_id));
    }


    public function printSkills(Request $request)
    {
            $skills=$this->Query($request);
        return view('re_skills.skills',compact("skills","request"));

    }
}
