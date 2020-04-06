<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Countery;
use \App\State;
use \App\Regional;
use \App\Unit;
use \App\User;
use \App\Auth;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {

        if ($id == null)
            {
                $countreis = Countery::all();
                $states = State::all();
                $regionals = Regional::all();
                $units = Unit::all();
                return view('units.index',compact('units','regionals','states','countreis'));
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

                    $unit_name   = $request->name;
                    $regionals  = $request->regional_id;

                    $unit  = new Unit();

                    $unit->name        = $unit_name;
                    $unit->regional_id = $regionals;

                    $unit->save();

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
        $units = Unit::find($id);
        $regionals = Regional::all();
        return view('units.edit',compact('units','regionals'));
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
            $units = Unit::find($id);
            $units -> name = $request -> name;
            $units -> regional_id = $request -> regional_id;

            $units -> save();

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
           Unit::find($id)->delete();
            return response("done");
    }



    public function getUnits(Request $request) {
        $units = \App\Unit::where('regional_id',$request->uid)->get();
        $options = '<option selected="selected" hidden="hidden" value="">إختر الوحدة الإدارية </option>';
        foreach ($units as $unit) {
            $options .= '<option value="'.$unit->unit_id.'">'.$unit->name.'</option>';
        }

        return $options;
    }
}
