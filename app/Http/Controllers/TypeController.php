<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Type;
use \App\User;

class TypeController extends Controller
{
    public function index()
    {
    	$types = Type::all();
    	return view('types_univers.index',compact('types'));
    }


     public function store( Request $request)
    {
    	$name        = $request->name;

    	$type = new Type();

    	$type->name = $name;
    	$type-> save();

    	return response('done');


    }


     public function edit($id)
    {
        $type = Type::find($id);

        return view('types_univers.edit',compact('type'));
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
        $type = Type::find($id);
        $type -> name = $request->name;

        $type->save();

        return response('done');
    }

     public function destroy($id)
    {
        Type::find($id)->delete();
        return response("done");
    }


    public function getUniversities(Request $request) {
        if($request->type and $request->uni){
            $universities = \App\University::where('type_id',$request->type)->where('countery_id',$request->uni)->get();
        }else if(!$request->type and !$request->uni){
            $universities = \App\University::all()->get();
        }else if($request->type and !$request->uni){
            $universities = \App\University::where('type_id',$request->type)->get();
        }else if(!$request->type and $request->uni){
            $universities = \App\University::where('countery_id',$request->uni)->get();
        }
        
        $options = '<optgroup  label="'.trans('strings.select_univers-label').'">
                     <option selected="selected" value="" >'.trans('strings.select_univers-label').'</option>';
        foreach ($universities as $university) {
            $options .= '<option value="'.$university->university_id.'">'.$university->name.'</option>';
        }
        $options .= '</optgroup >';

        return $options;
    }


}
