<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Countery;
use \App\University;
use \App\College;
use \App\Auth;

class CollegesController extends Controller
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
                    $colleges = College::all();
                    $universities = University::all();
                    return view('colleges.index',compact('colleges','universities'));
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

        $col_name        = $request->name;
        $universities    = $request->university_id;


        $college = new College();

        $college->name = $col_name;
        $college->university_id = $universities;

        $college->save();
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
        $colleges = College::find($id);
        $universities = University::all();
        return view('colleges.edit',compact('colleges','universities'));
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
                $colleges = College::find($id);
                $colleges -> name = $request->name;
                $colleges->university_id = $request->university_id;

                $colleges->save();

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
        College::find($id)->delete();
        return response("done");
    }


    public function getDepartments(Request $request) {
        $departments = \App\Department::where('college_id',$request->cid)->get();
        $options = '<optgroup  label="'.trans('strings.select_depart-label').'">
                     <option selected="selected" value="" >'.trans('strings.departments').'</option>';
        foreach ($departments as $dept) {
            $options .= '<option value="'.$dept->depart_id.'">'.$dept->name.'</option>';
        }
        $options .= '</optgroup >';

        return $options;
    }

}
