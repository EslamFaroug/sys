<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Degree;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactReportController extends Controller
{

    public function index(){
        $universities  = University::all();
        $degrees=Degree::all();
        $contacts=Contact::all();
            return view('re_contact.index', compact(['contacts','universities','degrees']));

    }

    public function resultContact(Request $request)
    {
         if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $contacts=Contact::all();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("colleges","colleges.college_id","=","contacts.college_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university', 'colleges.name as college')
                 ->where('teachers.ar_name','like',$request->value.'%')->orWhere('teachers.en_name','like',$request->value.'%')
                 ->orWhere('counteries.name','like',$request->value.'%')->orWhere('contacts.mobile_no','like',$request->value.'%')
                 ->orWhere('contacts.email','like',$request->value.'%')->orWhere('contacts.tel_no','like',$request->value.'%')
                 ->orWhere('universities.name','like',$request->value.'%')
                 ->get();
          }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->unionAll($first)
                 ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->unionAll($first)
                 ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->unionAll($first)
                 ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->unionAll($first)
                 ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
             $first=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.ar_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('teachers.degree_id','=',$request->degree_id);
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.en_name','like','%'.$request->value.'%')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->unionAll($first)
                 ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('contacts.university_id','=',$request->university_id)
                 ->Where('contacts.college_id','=',$request->college_id)
                 ->Where('contacts.depart_id','=',$request->depart_id)
                 ->Where('contacts.special_id','=',$request->special_id)
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
             $contacts=DB::table("contacts")
                 ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                 ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                 ->join("universities","universities.university_id","=","contacts.university_id")
                 ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                 ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                 ->Where('teachers.degree_id','=',$request->degree_id)
                 ->get();
        }
        $html= view('re_contact.row',['contacts'=>$contacts])->render();
        return response(['status'=>true,'result'=>$html]);
    }

    public function printContact($id=null)
    {
        return view('re_contact.contact')
            ->with('teacher',Teacher::find(Contact::find($id)->teacher_id));
    }

    public function viewContact($id=null)
    {
        return view('re_contact.contactView')
            ->with('teacher',Teacher::find(Contact::find($id)->teacher_id));
    }


    public function printContacts(Request $request)
    {
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $contacts=Contact::all();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("colleges","colleges.college_id","=","contacts.college_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university', 'colleges.name as college')
                ->where('teachers.ar_name','like',$request->value.'%')->orWhere('teachers.en_name','like',$request->value.'%')
                ->orWhere('counteries.name','like',$request->value.'%')->orWhere('contacts.mobile_no','like',$request->value.'%')
                ->orWhere('contacts.email','like',$request->value.'%')->orWhere('contacts.tel_no','like',$request->value.'%')
                ->orWhere('universities.name','like',$request->value.'%')
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('contacts.university_id','=',$request->university_id)
                ->Where('contacts.college_id','=',$request->college_id)
                ->Where('contacts.depart_id','=',$request->depart_id)
                ->Where('contacts.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $contacts=DB::table("contacts")
                ->join("counteries","contacts.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","contacts.teacher_id")
                ->join("universities","universities.university_id","=","contacts.university_id")
                ->join("degrees","teachers.degree_id","=","degrees.degree_id")
                ->select('contacts.*','teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name','counteries.name as countery', 'universities.name as university')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        return view('re_contact.contacts',compact("contacts","request"));

    }


}
