<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Countery;
use \App\User;
use \App\Auth;

 class CounteryController extends Controller
{

    public function index()
    {
    	$countreis = Countery::all();
    	return view('countreis.index',compact('countreis'));
    }


    public function store( Request $request)
    {
    	$name        = $request->name;
    	$symbol      = $request->symbole;
    	//$nationality = $request->nationality;

    	$count = new Countery();

    	$count->name = $name;
    	$count->symbole = $symbol;
    	//$count->nationality = $nationality;

    	$count-> save();

    	return response('done');


    }

     public function edit($id)
    {
        $count = Countery::find($id);

        return view('countreis.edit',compact('count'));
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
        $count = Countery::find($id);
        $count -> name = $request->name;
        $count -> symbole = $request->symbole;
        //$count -> nationality = $request->nationality;

        $count->save();

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
        Countery::find($id)->delete();
        return response("done");
    }






    public function getStates(Request $request) {
        $states = \App\State::where('countery_id',$request->cid)->get();
        $options = '<option selected="selected" hidden="hidden" value="">إختر الولاية</option>';
        foreach ($states as $state) {
            $options .= '<option value="'.$state->state_id.'">'.$state->name.'</option>';
        }

        return $options;
    }


}
