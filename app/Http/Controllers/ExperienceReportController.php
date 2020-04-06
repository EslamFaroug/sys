<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Countery;
use App\Degree;
use App\Experience;
use App\Mangejob;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExperienceReportController extends Controller
{
    public function index(){
        $universities  = University::all();
        $degrees=Degree::all();
        $mangejobs=Mangejob::all();
        $countries  = Countery::all();

        $experiences=DB::table("experiences")->distinct()
            ->join("counteries","experiences.countery_id","=","experiences.countery_id")
            ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
            ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
            ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
            ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
            ->leftJoin("universities","universities.university_id","=","experiences.university_id")
            ->select('experiences.*',
                'teachers.en_name as teacher_en_name',
                'teachers.ar_name as teacher_ar_name',
                'counteries.name as countery',
                'work_types.name as work',
                'degrees.name as degree'
                ,'universities.name as university',
                'mangejobs.name as mangejob')
            ->get();
        return view('re_experiences.index', compact(['experiences','countries','universities','degrees','mangejobs']));


    }

    public function resultExperience(Request $request)
    {
        $html= view('re_experiences.row',['experiences'=>$this->resultExperienceControl($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }

    public function resultExperienceControl(Request $request)
    {

        if($request->filter=="teach"){
            $experiences=$this->queriesTech($request);
        }else if($request->filter=="mange") {
            $experiences=$this->queriesMange($request);

        }
        else if($request->filter=="exp") {
            $experiences=$this->queriesExp($request);
        }else if(!$request->filter and $request->value) {
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->orWhere('teachers.ar_name','like','%'.$request->value.'%')
                ->orWhere('teachers.en_name','like','%'.$request->value.'%')
                ->orWhere('counteries.name','like','%'.$request->value.'%')
                ->orWhere('universities.name','like','%'.$request->value.'%')
                ->orWhere('work_types.name','like','%'.$request->value.'%')
                ->orWhere('mangejobs.name','like','%'.$request->value.'%')
                ->orWhere('experiences.exp_name','like','%'.$request->value.'%')
                ->orWhere('experiences.institute','like','%'.$request->value.'%')
                ->get();
        }else{
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')

                ->get();
        }

        return $experiences;
    }
    private function queriesTech($request){
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->Where('experiences.degree_id','=',$request->degree_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.degree_id','=',$request->degree_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.degree_id','=',$request->degree_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.degree_id','=',$request->degree_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.degree_id','=',$request->degree_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','!=',"")
                ->Where('experiences.degree_id','=',$request->degree_id)
                ->get();
        }
        return $experiences;
    }
    private function queriesMange($request){
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.mangejob_id','=',$request->mangejob_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id);
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.university_id','=',$request->university_id)
                ->Where('experiences.college_id','=',$request->college_id)
                ->Where('experiences.depart_id','=',$request->depart_id)
                ->Where('experiences.special_id','=',$request->special_id)
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->mangejob_id ){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.mangejob_id','!=',"")
                ->Where('experiences.mangejob_id','=',$request->mangejob_id)
                ->get();
        }
        return $experiences;
    }
    private function queriesExp($request){
        if($request->value and $request->exp_name and $request->institute  ){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.institute','like','%'.$request->institute.'%')
                ->Where('experiences.exp_name','like','%'.$request->exp_name.'%');
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.institute','like','%'.$request->institute.'%')
                ->Where('experiences.exp_name','like','%'.$request->exp_name.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->exp_name and !$request->institute){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.exp_name','!=',null)
                ->get();
        }else if($request->value and !$request->exp_name and !$request->institute){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.exp_name','!=',null)
                ->Where('teachers.en_name','like','%'.$request->value.'%');
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.exp_name','!=',null)
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->exp_name and !$request->institute){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.exp_name','like','%'.$request->exp_name.'%');
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.exp_name','like','%'.$request->exp_name.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->exp_name and $request->institute){
            $first=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('experiences.institute','like','%'.$request->institute.'%');
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('experiences.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->exp_name and !$request->institute){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('experiences.exp_name','like','%'.$request->exp_name.'%')
                ->get();

        }else if(!$request->value and $request->exp_name and $request->institute){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('experiences.institute','like','%'.$request->institute.'%')
                ->Where('experiences.exp_name','like','%'.$request->exp_name.'%')
                ->get();
        }else if(!$request->value and !$request->exp_name and $request->institute){
            $experiences=DB::table("experiences")->distinct()
                ->join("counteries","experiences.countery_id","=","experiences.countery_id")
                ->join("teachers","teachers.teacher_id","=","experiences.teacher_id")
                ->join("work_types","work_types.work_id","=","experiences.work_id")->distinct()
                ->leftJoin("degrees","degrees.degree_id","=","experiences.degree_id")
                ->leftJoin("mangejobs","mangejobs.mangejob_id","=","experiences.mangejob_id")
                ->leftJoin("universities","universities.university_id","=","experiences.university_id")
                ->select('experiences.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'work_types.name as work',
                    'degrees.name as degree'
                    ,'universities.name as university',
                    'mangejobs.name as mangejob')
                ->Where('experiences.degree_id','=',null)
                ->Where('experiences.mangejob_id','=',null)
                ->Where('experiences.institute','like','%'.$request->institute.'%')
                ->get();
        }
        return $experiences;
    }

    public function printExperience($id=null)
    {
         return view('re_experiences.experience')
            ->with('teacher',Teacher::find(Experience::find($id)->teacher_id));
    }

    public function viewExperience($id=null)
    {
        return view('re_experiences.experienceView')
            ->with('teacher',Teacher::find(Experience::find($id)->teacher_id));
    }


    public function printExperiences(Request $request)
    {
           $experiences=$this->resultExperienceControl($request);

        return view('re_experiences.experiences', compact("experiences", "request"));

    }
}
