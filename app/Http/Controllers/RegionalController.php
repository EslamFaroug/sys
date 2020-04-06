<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Countery;
use \App\State;
use \App\Regional;
use \App\User;
use \App\Auth;

class RegionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        if ($id == null) 
            {
                $countreis = Countery::all();
                $states = State::all();
                $regionals = Regional::all();
                return view('regionals.index',compact('regionals','states','countreis'));
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

                    $reg_name   = $request->name;
                    $states  = $request->state_id;

                    $regional  = new Regional();

                    $regional->name        = $reg_name;
                    $regional->state_id = $states;

                    $regional->save();

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
        $regionals = Regional::find($id);
        $states = State::all();
        return view('regionals.edit',compact('regionals','states'));
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
        $regionals = Regional::find($id);
        $regionals -> name = $request -> name;
        $regionals -> state_id = $request -> state_id;

        $regionals -> save();

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
                    Regional::find($id)->delete();
                    return response("done");
    }
}
