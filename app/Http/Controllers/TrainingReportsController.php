<?php

namespace App\Http\Controllers;

use App\Countery;
use App\Degree;
use App\Special;
use App\Teacher;
use App\Train;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingReportsController extends Controller
{
    public function index(){
        $countries  = Countery::all();
        $universities  = University::all();
        $Specializations=Special::all();
        $trainings=DB::table("trains")->distinct()
            ->join("counteries","counteries.countery_id","=","trains.countery_id")
            ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
            ->join("specials","specials.special_id","=","trains.special_id")->distinct()
            ->select('trains.*',
                'teachers.en_name as teacher_en_name',
                'teachers.ar_name as teacher_ar_name',
                'counteries.name as countery',
                'specials.name as special')
            ->get();
        return view('re_training.index', compact(['trainings','countries','universities','Specializations']));


    }

    public function resultTraining(Request $request)
    {
        $html= view('re_training.row',['trainings'=>$this->resultControl($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }
    public function resultControl($request )
    {

        if($request->filter=="training_place"){
            $trainings=$this->queriesTraining_place($request);
        }else if($request->filter=="trainuing_field") {
            $trainings=$this->queriesTrainuing_field($request);

        }
        else if($request->filter=="univ") {
            $trainings=$this->queriesUniv($request);
        }else if(!$request->filter and $request->title or $request->institute or $request->value  ) {
            $trainings=$this->queriesOther($request);
        }else{
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->get();
        }

        return $trainings;
    }

    private function queriesTraining_place($request){
        if($request->value and $request->country_id and $request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->country_id and !$request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->get();
        }else if($request->value and !$request->country_id and !$request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->country_id and !$request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id);
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->country_id and $request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->country_id and !$request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->country_id and $request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->country_id and !$request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->country_id and $request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->country_id and !$request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->get();
        }else if(!$request->value and $request->country_id and $request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and $request->country_id and !$request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and $request->country_id and $request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.countery_id','=',$request->countery_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and !$request->country_id and $request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and !$request->country_id and $request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and !$request->country_id and !$request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }
        return $trainings;
    }
    private function queriesTrainuing_field($request){
        if($request->value and $request->trainuing_field and $request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->trainuing_field and !$request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->get();
        }else if($request->value and !$request->trainuing_field and !$request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->trainuing_field and !$request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field);
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->trainuing_field and $request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->trainuing_field and !$request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->trainuing_field and $request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->trainuing_field and !$request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->trainuing_field and $request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->trainuing_field and !$request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->get();
        }else if(!$request->value and $request->trainuing_field and $request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and $request->trainuing_field and !$request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and $request->trainuing_field and $request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.special_id','=',$request->trainuing_field)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and !$request->trainuing_field and $request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and !$request->trainuing_field and $request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and !$request->trainuing_field and !$request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }
        return $trainings;
    }
    private function queriesUniv($request){
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and $request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id);
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id);
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and !$request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and $request->title and !$request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and !$request->title and $request->institute  ){
               $first=DB::table("trains")->distinct()
                   ->join("counteries","counteries.countery_id","=","trains.countery_id")
                   ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                   ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                   ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                   ->select('trains.*',
                       'teachers.en_name as teacher_en_name',
                       'teachers.ar_name as teacher_ar_name',
                       'counteries.name as countery',
                       'specials.name as special')
                   ->Where('teachers.ar_name','like','%'.$request->value.'%')
                   ->Where('contacts.university_id','=',$request->university_id)
                   ->Where('contacts.college_id','=',$request->college_id)
                   ->Where('contacts.depart_id','=',$request->depart_id)
                   ->Where('contacts.special_id','=',$request->special_id)
                   ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id  and $request->title and $request->institute  ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and $request->title and $request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id  and !$request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and !$request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and $request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id  and !$request->title and $request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and !$request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and $request->title and $request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id  and !$request->title and $request->institute  ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }
        return $trainings;
    }
    private function queriesOther($request){
        if($request->value  and $request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value  and !$request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value  and $request->title and !$request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->unionAll($first)
                ->get();
        }else if($request->value  and !$request->title and $request->institute ){
            $first=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%');
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->value  and $request->title and !$request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->get();
        }else if(!$request->value  and $request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.title','like','%'.$request->title.'%')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }else if(!$request->value  and !$request->title and $request->institute ){
            $trainings=DB::table("trains")->distinct()
                ->join("counteries","counteries.countery_id","=","trains.countery_id")
                ->join("teachers","teachers.teacher_id","=","trains.teacher_id")
                ->join("specials","specials.special_id","=","trains.special_id")->distinct()
                ->select('trains.*',
                    'teachers.en_name as teacher_en_name',
                    'teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery',
                    'specials.name as special')
                ->Where('trains.institute','like','%'.$request->institute.'%')
                ->get();
        }
        return $trainings;
    }

    public function printTraining($id=null)
    {
        return view('re_training.training')
            ->with('teacher',Teacher::find(Train::find($id)->teacher_id));
    }

    public function viewTraining($id=null)
    {
        return view('re_training.trainingView')
            ->with('teacher',Teacher::find(Train::find($id)->teacher_id));
    }


    public function printTrainings(Request $request)
    {
        $trainings= $this->resultControl($request);
        return view('re_training.trainings',compact("trainings","request"));

    }
}
