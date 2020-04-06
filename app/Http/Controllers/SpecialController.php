<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\University;
use \App\College;
use \App\Department;
use \App\Special;
use \App\User;
use \App\Auth;
class SpecialController extends Controller
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

        $departments  = Department::all();
        $universities = University::all();
        $colleges     = College::all();
        $specials     = Special::all();

        return view('specials.index',compact('departments','universities','colleges','specials'));

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

            $sp_name                = $request->name;
            $sp_type                = $request->special_type;
            $departments            = $request->depart_id;

            $special                = new Special();

            $special->name          = $sp_name;
            $special->special_type  = $sp_type;
            $special->depart_id     = $departments;

            $special-> save();

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
                $universities = University::all();
                $colleges     = College::all();
                $specials        = Special::find($id);
                $departments     = Department::all();
                return view('specials.edit',compact('universities','colleges','specials','departments'));
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
                $special                  = Special::find($id);
                $special ->name          = $request->name;
                $special ->special_type  = $request->special_type;
                $special->depart_id     = $request->depart_id;

                $special-> save();

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
        Special::find($id)->delete();
        return response("done");
    }

    public function getSpecials(Request $request) {
        $specials = \App\Special::where('depart_id',$request->sid)->get();
        $options = '<optgroup  label="'.trans('strings.specail_title').'">
                  <option selected="selected" value="">'.trans("strings.specail_title").'</option>';
        foreach ($specials as $special) {
            $options .= '<option value="'.$special->special_id.'">'.$special->name.'</option>';
        }

        return $options;
    }
}
