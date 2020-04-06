<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Teacher;
use \App\Skill;
use \App\User;
use \App\Auth;
class SkillsController extends Controller
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
            $teachers = Teacher::all();
            $skills   = Skill::all();
            return view('skills.index', compact('teachers','skills'));
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
                    $tr_name       = $request->teacher_id;
                    $skill_name      = $request->name;
                    $skill_dec     = $request->decription;

                    $skill       = new Skill();

                    $skill->teacher_id    = $tr_name;
                    $skill->name         = $skill_name;
                    $skill->decription     = $skill_dec;


                    $skill->save();

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
            $teachers = Teacher::all();
            $skills   = Skill::find($id);
            return view('skills.edit', compact('teachers','skills'));
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
        
                $skill                  = Skill::find($id);

                $skill ->teacher_id     = $request->teacher_id;
                $skill ->name           = $request->name;
                $skill ->decription     = $request->decription;


                $skill-> save();
                    
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
        Skill::find($id)->delete();
        return response("done");
    }
}
