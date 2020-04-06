<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Conference;
use \App\Teacher;
use \App\Countery;
use \App\State;
use \App\User;
use \App\Auth;
class ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if($id == null)
        {
            $conferences = Conference::all();
            $teachers    = Teacher::all();
            $countreis   = Countery::all();
            $states      = State::all();
                return view('conferences.index',
                 compact('conferences','teachers','countreis','states'));
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

        $tr_name             = $request->teacher_id;
        $conf_name           = $request->name;
        $cout_name           = $request->countery_id;
        $st_name             = $request->state_id;
        $type_part           = $request->participant;
        $con_date            = $request->conf_date;

        $confer              = new Conference();
        $confer->teacher_id  = $tr_name;
        $confer->name        = $conf_name;
        $confer->countery_id = $cout_name;
        $confer->state_id    = $st_name;
        $confer->participant = $type_part;
        $confer->conf_date   = $con_date;

        $confer->save();
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
            $conferences = Conference::find($id);
            $teachers    = Teacher::all();
            $countreis   = Countery::all();
            $states      = State::all();
                return view('conferences.edit',
                 compact('conferences','teachers','countreis','states'));
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
                $conferences = Conference::find($id);
                $conferences ->teacher_id   = $request->teacher_id;
                $conferences ->name         = $request->name;
                $conferences ->countery_id  = $request->countery_id;
                $conferences ->state_id     = $request->state_id;
                $conferences ->participant  = $request->participant;
                $conferences ->conf_date    = $request->conf_date;


                $conferences-> save();
                    
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
        Conference::find($id)->delete();
            return response("done");
    }
}
