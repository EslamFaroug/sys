<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use \App\Countery;
use \App\State;
use \App\Regional;
use \App\Teacher;
use \App\University;
use \App\Degree;
use \App\User;
use \App\Auth;
class TeacherController extends Controller
{

    private $martialStatus = array(
        '1'=>'عازب',
        '2'=>'متزوج',
        '3'=>'منفصل',
        '4'=>'أرملة',
            );

    private $languages = array(
        '1'=>'العربية',
        '2'=>'الإنجليزية',
        '3'=>'الفرنسية',
        '4'=>'الألماني',
        '5'=>'الإيطالي',
        '6'=>'الساحلية',
        );


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        if ($id == null){
            $martialStatus = $this->martialStatus;
            $languages     = $this->languages;
            $countreis     = Countery::all();
            $teachers      = Teacher::all();
            $regionals     = Regional::all();
            $degrees       = Degree::all();

            return view('teachers.index', compact('martialStatus','languages','teachers','countreis','regionals','degrees'));
        }

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

        $tr_ar_name              = $request->ar_name;
        $tr_en_name              = $request->en_name;
        $card_no                 = $request->card_id ;
        $date_of_birth           = $request->dob ;
        $place_of_birth          = $request->pob ;
        $sex                     = $request->gender ;
        $martial_status          = $request->status ;
        $mother_lang             = $request->mother_tounge;
        $nationality             = $request->countery_id;
        $degree_tech             = $request->degree_id;

        $basic_taecher = new Teacher();

        $basic_taecher->ar_name         = $tr_ar_name;
        $basic_taecher->en_name         = $tr_en_name;
        $basic_taecher->card_id         = $card_no;
        $basic_taecher->dob             = $date_of_birth;
        $basic_taecher->pob             = $place_of_birth;
        $basic_taecher->gender          = $sex;
        $basic_taecher->status          = $martial_status;
        $basic_taecher->mother_tounge   = $mother_lang;
        $basic_taecher->countery_id     = $nationality;
        $basic_taecher->degree_id       = $degree_tech;
        $user=new User();
        $user->name=$tr_en_name;
        $user->email=$request->email;
        $user->password=bcrypt($request->email);
        $user->save();
        $basic_taecher->user_id       = $user->id;
        if($basic_taecher-> save()){
            $contact=new Contact();
            $contact->teacher_id=$basic_taecher->teacher_id;
            $contact->email=$request->email;
            $contact->save();
        }

           return response('done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $martialStatus = $this->martialStatus;
            $languages     = $this->languages;
            $countreis     = Countery::all();
            $teachers      = Teacher::find($id);
            $regionals     = Regional::all();
            $degrees       = Degree::all();

            return view('teachers.edit', compact('martialStatus','languages','teachers','countreis','regionals','degrees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $teacher = Teacher::find($id);

        $teacher ->ar_name       = $request->ar_name;
        $teacher ->en_name       = $request->en_name;
        $teacher ->card_id       = $request->card_id;
        $teacher ->dob           = $request->dob;
        $teacher ->pob           = $request->pob;
        $teacher ->gender        = $request->gender;
        $teacher ->status        = $request->status;
        $teacher ->mother_tounge = $request->mother_tounge;
        $teacher ->countery_id   = $request->countery_id;
        $teacher ->degree_id     = $request->degree_id;
        if($teacher->save()){
            $contact=Contact::where('teacher_id',$teacher->teacher_id)->first();
            $contact->email=$request->email;
            $contact->save();
        }


        return response('done');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $t=Teacher::find($id);
        User::find($t->user_id)->delete();
        $t->delete();
        return response("done");
    }
}
