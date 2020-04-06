<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Teacher;
use \App\Countery;
use \App\University;
use \App\College;
use \App\Department;
use \App\Special;
use \App\Mangejob;
use \App\Work_type;
use \App\Type;
use \App\Experience;
use \App\Degree;
use \App\User;
use \App\Auth;
use \App\Contact;
class ExperiencController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        if($id == null)
        {

            $teachers  = Teacher::all();
            $experiences  = Experience::all();
            $countreis    = Countery::all();
            $universities = University::all();
            $colleges     = College::all();
            $departments  = Department::all();
            $specials     = Special::all();
            $mangejobs    = Mangejob::all();
            $work_types   = Work_type::all();
            $types        = Type::all();
            $degrees        = Degree::all();

            return view('experiences.index', compact('teachers','experiences','countreis','universities','colleges','departments','specials','mangejobs','work_types','types','degrees'));

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
//die ($request->teacher_id);

        $inst_name             = $request->institute;
        $uni_name              = $request->university_id;
        $colleg_name           = $request->college_id;
        $dept_name             = $request->depart_id;
        $spec_name             = $request->special_id;
        $work                  = $request->work_id;
        $type                  = $request->type_id;
        $count_name            = $request->countery_id;
        $work_place            = $request->work_place_2;
        $st_date               = $request->start_date;
        $en_date               = $request->end_date;
        $desc_name             = $request->decrip;

        $experi                = new Experience();
        $experi->teacher_id    = $request->teacher_id;;
        $experi->degree_id     = $request->degree_id;
        $experi->mangejob_id   = $request->mangejob_id;
        $experi->exp_name      = $request->exp_name;;
        $experi->institute     = $inst_name;
        $experi->university_id = $uni_name;
        $experi->college_id    = $colleg_name;
        $experi->depart_id     = $dept_name;
        $experi->special_id    = $spec_name;
        $experi->work_id       = $work;
        $experi->type_id       = $type;
        $experi->countery_id   = $count_name;
        $experi->work_place_2  = $work_place;
        $experi->start_date    = $st_date;
        $experi->end_date      = $en_date;
        $experi->decrip        = $desc_name;

        $experi->save();
            return back()->with('Success','Data Saved Seccessfully');
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

            $experience  = Experience::find($id);
            $teachers     = Teacher::all();
            $countreis    = Countery::all();
            $universities = University::all();
            $colleges     = College::all();
            $departments  = Department::all();
            $specials     = Special::all();
            $mangejobs    = Mangejob::all();
            $work_types   = Work_type::all();
            $types        = Type::all();
            $degrees      = Degree::all();
       //  die($experience);
            return view('experiences.edit', compact('teachers','experience','countreis','universities','colleges','departments','specials','mangejobs','work_types','types','degrees'));
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
        $inst_name             = $request->institute;
        $uni_name              = $request->university_id;
        $colleg_name           = $request->college_id;
        $dept_name             = $request->depart_id;
        $spec_name             = $request->special_id;
        $work                  = $request->work_id;
        $type                  = $request->type_id;
        $count_name            = $request->countery_id;
        $work_place            = $request->work_place_2;
        $st_date               = $request->start_date;
        $en_date               = $request->end_date;
        $desc_name             = $request->decrip;

        $experi                = Experience::find($id);
        $experi->teacher_id    = $request->teacher_id;;
        $experi->degree_id     = $request->degree_id;
        $experi->mangejob_id   = $request->mangejob_id;
        $experi->exp_name      = $request->exp_name;;
        $experi->institute     = $inst_name;
        $experi->university_id = $uni_name;
        $experi->college_id    = $colleg_name;
        $experi->depart_id     = $dept_name;
        $experi->special_id    = $spec_name;
        $experi->work_id       = $work;
        $experi->type_id       = $type;
        $experi->countery_id   = $count_name;
        $experi->work_place_2  = $work_place;
        $experi->start_date    = $st_date;
        $experi->end_date      = $en_date;
        $experi->decrip        = $desc_name;
        if($experi->save()){
            return response("done");

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Experience::find($id)->delete();
            return response("done");
    }
}
