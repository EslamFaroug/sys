<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Research;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookReportsController extends Controller
{
    public function index($id=null)
    {
        $universities  = University::all();
        $degrees=Degree::all();
        $books=DB::table("books")
            ->join("teachers","teachers.teacher_id","=","books.teacher_id")
            ->join("degrees","teachers.degree_id","=","degrees.degree_id")
            ->select('teachers.*','books.*', 'degrees.name as degree')
            ->get();
        return view('re_books.index', compact(['books','universities','degrees']));



    }

    public function resultBook(Request $request)
    {
        //return $this->resultControl($request);

        $html= view('re_books.rows',['books'=>$this->resultControl($request)])->render();
        return response(['status'=>true,'result'=>$html]);
    }
    public function resultControl($request )
    {

        if($request->filter=="book"){
            $books=$this->queriesBook($request);
        }else if($request->filter=="univ_title") {
            $books=$this->queriesUniv($request);

        }
        else if($request->filter=="degree") {
            $books=$this->queriesDegree($request);
        }else if(!$request->filter and $request->title or $request->date or $request->value  ) {
            $books=$this->queriesOther($request);
        }else{
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->get();
        }

        return $books;
    }

    private function queriesUniv($request){
        if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->get();
        }else if($request->value and !$request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->unionAll($first)
                ->get();

        }else if($request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {

            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
            ;
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
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
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if($request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $first = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        } else if(!$request->value and $request->title and !$request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->get();
        }else if(!$request->value and $request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {

            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and !$request->title and $request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and !$request->title and !$request->date and  $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        } else if(!$request->value and !$request->title and !$request->date and  $request->university_id and $request->college_id and $request->depart_id  and $request->special_id) {
            $books = DB::table("books")
                ->join("teachers", "teachers.teacher_id", "=", "books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees", "teachers.degree_id", "=", "degrees.degree_id")
                ->select('teachers.*', 'books.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }


        return $books;


    }
    private function queriesDegree($request){
        if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {

            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)

            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {

            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {


            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();

        }else if($request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {

            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title', 'like', '%' . $request->title . '%')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $begin = substr($request->date, 0, 10);
            $end = substr($request->date, 12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition', [$begin, $end])
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
            ;
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name', 'like', '%' . $request->value . '%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and !$request->university_id and !$request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and !$request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->degree_id and $request->university_id and $request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and !$request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and !$request->degree_id and $request->university_id and $request->college_id) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("contacts","contacts.teacher_id","=","teachers.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }


        return $books;


    }
    private function queriesBook($request){
        if($request->title and $request->date and  $request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  !$request->value and !$request->publisher) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->get();
        }else if($request->title and !$request->date and  !$request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->get();

        }else if($request->title and $request->date and  !$request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value and !$request->publisher) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value and $request->publisher) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->get();
        }else if($request->title and $request->date and  $request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if($request->title and $request->date and  !$request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->get();
        }else if($request->title and !$request->date and  $request->value and $request->publisher) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->get();
        }else if(!$request->title and $request->date and  $request->value and !$request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and $request->date and  !$request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->get();
        }else if(!$request->title and $request->date and  $request->value and $request->publisher) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and !$request->publisher) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  $request->value and $request->publisher) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->unionAll($first)
                ->get();
        }else if(!$request->title and !$request->date and  !$request->value and $request->publisher) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.publisher','like','%'.$request->publisher.'%')
                ->get();
        }


        return $books;


    }
    private function queriesOther($request){
        if($request->title and $request->date and  $request->value  ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if($request->title and !$request->date and  !$request->value ) {
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->get();
        }else if($request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->get();

        }else if($request->title and !$request->date and  $request->value ) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->where('books.title','like','%'.$request->title.'%')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and $request->date and  !$request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->get();

        }else if(!$request->title and $request->date and  $request->value ) {
            $begin=substr($request->date,0,10);
            $end=substr($request->date,12);
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->whereBetween('books.f_edition',[$begin,$end])
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();

        }else if(!$request->title and !$request->date and  $request->value ) {
            $first=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.ar_name','like','%'.$request->value.'%');
            $books=DB::table("books")
                ->join("teachers","teachers.teacher_id","=","books.teacher_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('teachers.*','books.*', 'degrees.name as degree')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->unionAll($first)
                ->get();
        }


        return $books;


    }

    public function viewBook($id=null)
    {
        return view('re_books.bookView')
            ->with('teacher',Teacher::find(Research::find($id)->teacher_id));
    }


    public function printBook($id)
    {
        return view('re_books.book')
            ->with('teacher',Teacher::find(Research::find($id)->teacher_id));
    }
    public function printBooks(Request $request)
    {
        $books=$this->resultControl($request);
        return view('re_books.books',compact("books","request"));
    }
}
