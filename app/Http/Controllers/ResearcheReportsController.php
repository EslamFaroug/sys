<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Research;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResearcheReportsController extends Controller
{
    public function index($id=null)
    {
        $universities  = University::all();
        $degrees=Degree::all();
        $researches=DB::table("researches")
            ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
            ->join("degrees","teachers.degree_id","=","degrees.degree_id")
            ->select('teachers.*','researches.*', 'degrees.name as degree')
            ->get();
        return view('re_researches.index', compact(['researches','universities','degrees']));



    }

    public function resultResearche(Request $request)
    {
        //return $this->resultControl($request);

        $html= view('re_researches.rows',['researches'=>$this->resultControl($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }
    public function resultControl($request )
    {

        if($request->filter=="researche"){
            $researches=$this->queriesResearche($request);
        }else if($request->filter=="univ_title") {
            $researches=$this->queriesUniv($request);

        }
        else if($request->filter=="degree") {
            $researches=$this->queriesDegree($request);
        }else if(!$request->filter and $request->title or $request->date or $request->value  ) {
            $researches=$this->queriesOther($request);
        }else{
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->get();
        }

        return $researches;
    }

    private function queriesUniv($request){
        if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->unionAll($first)
                ->get();

        }else if($request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {

            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
            ;
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
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
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $first = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if(!$request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->get();
        }else if(!$request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $researches = DB::table("researches")
                ->join("teachers", "teachers.teacher_id", "=", "researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'researches.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }


        return $researches;


    }
    private function queriesDegree($request){
        if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {

            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)

            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {


            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {

            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }


        return $researches;


    }
    private function queriesResearche($request){
        if($request->title and $request->date and  $request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->publish_place) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->publish_place) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->publish_place) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }else if($request->title and $request->date and  $request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->title and $request->date and  !$request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }else if($request->title and !$request->date and  $request->value and $request->publish_place) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->publish_place) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->publish_place) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->publish_place) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }


        return $researches;


    }
    private function queriesOther($request){
        if($request->title and $request->date and  $request->value  ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value ) {
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->get();
        }else if($request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value ) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->where('researches.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->whereBetween('researches.publish_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  $request->value ) {
            $first=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $researches=DB::table("researches")
                ->join("teachers","teachers.teacher_id","=","researches.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','researches.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }


        return $researches;


    }

    public function viewResearche($id=null)
    {
        return view('re_researches.researcheView')
            ->with('teacher',Teacher::find(Research::find($id)->teacher_id));
    }


    public function printResearche($id)
    {
        return view('re_researches.researche')
            ->with('teacher',Teacher::find(Research::find($id)->teacher_id));
    }
    public function printResearches(Request $request)
    {
        $researches=$this->resultControl($request);
        return view('re_researches.researches',compact("researches","request"));
    }
}
