<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Paper;
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

class PaperReportsController extends Controller
{
    public function index($id=null)
    {
        $universities  = University::all();
        $degrees=Degree::all();
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->get();
        return view('re_papers.index', compact(['papers','universities','degrees']));



    }

    public function resultPaper(Request $request)
    {
        //return $this->resultControl($request);

        $html= view('re_papers.rows',['papers'=>$this->resultControl($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }
    public function resultControl($request )
    {

        if($request->filter=="paper"){
            $papers=$this->queriesPaper($request);
        }else if($request->filter=="univ_title") {
            $papers=$this->queriesUniv($request);

        }
        else if($request->filter=="degree") {
            $papers=$this->queriesDegree($request);
        }else if(!$request->filter and $request->title or $request->date or $request->value  ) {
            $papers=$this->queriesOther($request);
        }else{
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->get();
        }

        return $papers;
    }

    private function queriesUniv($request){
        if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
               ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->unionAll($first)
                ->get();

        }else if($request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
               ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
               ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
               ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
           $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
               ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
             ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
               ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {

            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                  ;
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
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
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $first = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if(!$request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->get();
        }else if(!$request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $papers = DB::table("papers")
                ->join("teachers", "teachers.teacher_id", "=", "papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'papers.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }


        return $papers;


    }
    private function queriesDegree($request){
        if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {

            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)

            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {


            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                 ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                 ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {

            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }


        return $papers;


    }
    private function queriesPaper($request){
        if($request->title and $request->date and  $request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->publish_place) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->publish_place) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->publish_place) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }else if($request->title and $request->date and  $request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->title and $request->date and  !$request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }else if($request->title and !$request->date and  $request->value and $request->publish_place) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->publish_place) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->publish_place) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->publish_place) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->publish_place) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.publish_place','like','%'.$request->publish_place.'%')
                ->get();
        }


        return $papers;


    }
    private function queriesOther($request){
        if($request->title and $request->date and  $request->value  ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value ) {
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->get();
        }else if($request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value ) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->where('papers.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->whereBetween('papers.publis_date',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  $request->value ) {
            $first=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $papers=DB::table("papers")
                ->join("teachers","teachers.teacher_id","=","papers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','papers.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }


        return $papers;


    }

    public function viewPaper($id=null)
    {
        return view('re_papers.paperView')
            ->with('teacher',Teacher::find(Paper::find($id)->teacher_id));
    }


    public function printPaper($id)
    {
        return view('re_papers.paper')
            ->with('teacher',Teacher::find(Paper::find($id)->teacher_id));
    }
    public function printPapers(Request $request)
    {
        $papers=$this->resultControl($request);
        return view('re_papers.papers',compact("papers","request"));
    }


}
