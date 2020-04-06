<?php

namespace App\Http\Controllers;

use App\Countery;
use App\Degree;
use App\Research;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConferencesReportsController extends Controller
{
    public function index($id=null)
    {
        $countries  = Countery::all();
        $universities  = University::all();
        $degrees=Degree::all();
        $conferences=DB::table("conferences")
            ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
            ->join("degrees","teachers.degree_id","=","degrees.degree_id")
            ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
            ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
            ->get();
        return view('re_conferences.index', compact(['conferences','countries','universities','degrees']));



    }

    public function resultConference(Request $request)
    {
        $html= view('re_conferences.rows',['conferences'=>$this->resultControl($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }
    public function resultControl($request )
    {

        if($request->filter=="conference"){
            $conferences=$this->queriesConference($request);
        }else if($request->filter=="univ_title") {
            $conferences=$this->queriesUniv($request);

        } else if($request->filter=="degree") {
            $conferences=$this->queriesDegree($request);
        }else if($request->filter=="country") {
            $conferences=$this->queriesCountry($request);
        }else if(!$request->filter and $request->title or $request->date or $request->value  ) {
            $conferences=$this->queriesOther($request);
        }else{
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->get();
        }

        return $conferences;
    }

    private function queriesUniv($request){
        if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where(/** @lang text */ 'contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->unionAll($first)
                ->get();

        }else if($request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if(!$request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->get();
        }else if(!$request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }


        return $conferences;


    }
    private function queriesDegree($request){
        if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {

            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)

            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {


            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {

            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }


        return $conferences;


    }
    private function queriesConference($request){
        if($request->title and $request->date and  $request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->publisher) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->publisher) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->publisher) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->get();
        }else if($request->title and $request->date and  $request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->title and $request->date and  !$request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->get();
        }else if($request->title and !$request->date and  $request->value and $request->publisher) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->publisher) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->publisher) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->publisher) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.publisher','like','%'.$request->publisher.'%')
                ->get();
        }


        return $conferences;


    }
    private function queriesCountry($request){
        if($request->value and $request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
               ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->value and !$request->title and !$request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->value and $request->title and !$request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->unionAll($first)
                ->get();

        }else if($request->value and !$request->title and !$request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)

            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)

            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)

                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {

            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)

            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {

            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {

            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and !$request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and !$request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and !$request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and !$request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and $request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and $request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and $request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and $request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if($request->value and !$request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }
        else if(!$request->value and $request->title and !$request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->get();
        }
        else if(!$request->value and $request->title and $request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->get();
        }
        else if(!$request->value and $request->title and !$request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->get();
        }
        else if(!$request->value and $request->title and !$request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        else if(!$request->value and $request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }
        else if(!$request->value and $request->title and $request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->get();
        }
        else if(!$request->value and $request->title and $request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        else if(!$request->value and $request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }
        else if(!$request->value and $request->title and !$request->date and  $request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        else if(!$request->value and $request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and $request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and $request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  $request->country_id and $request->degree_id and !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and $request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and $request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and $request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and $request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and $request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name', 'like', '%' . $request->title . '%')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  !$request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  $request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
            }
        else if(!$request->value and !$request->title and $request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
            } else if(!$request->value and !$request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and $request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and $request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and $request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date', [$begin, $end])
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->country_id and !$request->degree_id and  !$request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('conferences.countery_id','=',$request->country_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  !$request->country_id and $request->degree_id and  !$request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  !$request->country_id and $request->degree_id and  $request->university_id and $request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and !$request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  !$request->country_id and !$request->degree_id and  $request->university_id and $request->college_id ) {
            $conferences = DB::table("conferences")
                ->join("teachers", "teachers.teacher_id", "=", "conferences.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }

        return $conferences;


    }
    private function queriesOther($request){
        if($request->title and $request->date and  $request->value  ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value ) {
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->get();
        }else if($request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value ) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->where('conferences.name','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->whereBetween('conferences.conf_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  $request->value ) {
            $first=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $conferences=DB::table("conferences")
                ->join("teachers","teachers.teacher_id","=","conferences.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
->join("counteries", "conferences.countery_id", "=", "counteries.countery_id")
                ->select('teachers.*','conferences.*', 'degrees.name as degree', 'counteries.name as countery')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }


        return $conferences;


    }

    public function viewConference($id=null)
    {
        return view('re_conferences.conferenceView')
            ->with('teacher',Teacher::find(Research::find($id)->teacher_id));
    }


    public function printConference($id)
    {
        return view('re_conferences.conference')
            ->with('teacher',Teacher::find(Research::find($id)->teacher_id));
    }
    public function printConferences(Request $request)
    {
        $conferences=$this->resultControl($request);
        return view('re_conferences.conferences',compact("conferences","request"));
    }
}
