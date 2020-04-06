<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\College;
use App\Contact;
use App\Countery;
use App\Degree;
use App\Department;
use App\Genaral_Statistics;
use App\Regional;
use App\Special;
use App\State;
use App\Teacher;
use App\Type;
use App\Unit;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GenaralStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types      = Type::all();
        $countreis     = Countery::all();
        $genaralStatistics  = Genaral_Statistics::all();
        $degrees   = Degree::all();
        return view('genaralStatistics.index',compact('countreis','types','genaralStatistics','degrees'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'Statistic_title'=>[
                'required', 'string', 'max:255'
            ], 'Statistic_type'=>[
                'required',
            ], 'visibility'=>[
                'required',
            ]
        ]);
        $status=false;
        $GenaralStatistic=new Genaral_Statistics();
        $GenaralStatistic->title=$request->Statistic_title;
        $GenaralStatistic->Type=$request->Statistic_type;
        $GenaralStatistic->show=$request->visibility;
        $GenaralStatistic->countery_id=$request->countery_id;
        $GenaralStatistic->type_id=$request->type_id;
        $GenaralStatistic->university_id=$request->university_id;
        $GenaralStatistic->college_id=$request->college_id;
        $GenaralStatistic->depart_id=$request->depart_id;
        $GenaralStatistic->special_id=$request->special_id;
        $GenaralStatistic->degree_id=$request->degree_id;
        if($GenaralStatistic->save()){
         $status=true;
        }
        return response()->json(['status'=>$status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genaral_Statistics  $genaral_Statistics
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $status=false;
        $genaral_Statistic=Genaral_Statistics::find($request->id);
        $genaral_Statistic->show=$request->show;
        if($genaral_Statistic->save()){
            $status=true;
        }
        return response()->json(['status'=>$status,'show'=>$genaral_Statistic->show]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genaral_Statistics  $genaral_Statistics
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $GenaralStatistics=[];
        $Genaral_Statistics=Genaral_Statistics::all();
        foreach ($Genaral_Statistics as $statistic){
            array_push($GenaralStatistics,$this->result($statistic));
        }
        return $GenaralStatistics;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genaral_Statistics  $genaral_Statistics
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        $genaral_Statistic  = Genaral_Statistics::find($request->id);
        $pratical= $this->result($genaral_Statistic);
        $html= view("genaralStatistics.view",['genaral_Statistic'=>$genaral_Statistic,'pratical'=>$pratical])->render();
        return response(['result'=>$html]);
    }

    public function result($genaral_Statistic){
        if($genaral_Statistic->Type=='universities'){
              $result=$this->universitiesQueries($genaral_Statistic);
        }elseif ($genaral_Statistic->Type=='teachers'){
            $result=$this->teachersQueries($genaral_Statistic);
        }
        return $result;
    }

    private function universitiesQueries($genaral_Statistic){
        if($genaral_Statistic->countery_id and $genaral_Statistic->type_id){
            $total=University::where('countery_id',$genaral_Statistic->countery_id)->count();
            $actual=University::where('countery_id',$genaral_Statistic->countery_id)->where('type_id',$genaral_Statistic->type_id)->count();
            $percent=($actual*100)/$total;
        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id){
            $total=University::all()->count();
            $actual=University::all()->count();
            $percent=($actual*100)/$total;
        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id){
            $total=University::all()->count();
            $actual=University::where('countery_id',$genaral_Statistic->countery_id)->count();
            $percent=($actual*100)/$total;
        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id){
            $total=University::all()->count();
            $actual=University::where('type_id',$genaral_Statistic->type_id)->count();
            $percent=($actual*100)/$total;
        }
        if($total>0){
            $percent=($actual*100)/$total;
        }else{
            $percent=0;
        }

        return response()->json(['genaral_Statistic'=>$genaral_Statistic,'total'=>$total,'actual'=>$actual,'percent'=>$percent]);
    }
    private function teachersQueries($genaral_Statistic){
        if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){

            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->count();
        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
               ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                 ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
               ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();
        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
               ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
               ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
               ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
               ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
               ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
               ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)

                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();

        }else if($genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)->count();

        }else if($genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.countery_id','=',$genaral_Statistic->countery_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)

                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)
                ->count();
        }else if(!$genaral_Statistic->countery_id and $genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('universities.type_id','=',$genaral_Statistic->type_id)
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  !$genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->count();
        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and $genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('teachers.degree_id','=',$genaral_Statistic->degree_id)
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and !$genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and !$genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and !$genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();

        }else if(!$genaral_Statistic->countery_id and !$genaral_Statistic->type_id  and !$genaral_Statistic->degree_id and  $genaral_Statistic->university_id and $genaral_Statistic->college_id and $genaral_Statistic->depart_id  and $genaral_Statistic->special_id){
            $total=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->count();
            $actual=DB::table("teachers")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("universities","contacts.university_id","=","universities.university_id")
                ->select('teachers.*')
                ->Where('contacts.university_id','=',$genaral_Statistic->university_id)
                ->Where('contacts.college_id','=',$genaral_Statistic->college_id)
                ->Where('contacts.depart_id','=',$genaral_Statistic->depart_id)
                ->Where('contacts.special_id','=',$genaral_Statistic->special_id)
                ->count();

        }
        if($total>0){
            $percent=($actual*100)/$total;
        }else{
            $percent=0;
        }

        return response()->json(['genaral_Statistic'=>$genaral_Statistic,'total'=>$total,'actual'=>$actual,'percent'=>$percent]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genaral_Statistics  $genaral_Statistics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Genaral_Statistics::find($request->id)->delete();
        return response("done");
    }
}
