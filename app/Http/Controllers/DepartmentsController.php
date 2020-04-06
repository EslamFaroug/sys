<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\University;
use \App\College;
use \App\Department;
use \App\User;
use \App\Auth;
class DepartmentsController extends Controller
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
               
                $departments  = Department::all();
                $universities = University::all();
                $colleges     = College::all();

                return view('departments.index',compact('departments','universities','colleges'));
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
                $dept_name   = $request->name;
                $colleges  = $request->college_id;

                $dept  = new Department();

                $dept->name        = $dept_name;
                $dept->college_id = $colleges;

                $dept->save();

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
         $departments = Department::find($id);
            $colleges = College::all();
                return view('departments.edit',compact('departments','colleges'));
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
                 $department = Department::find($id);
                 $department -> name = $request->name;
                 $department->college_id = $request->college_id;

                 $department->save();
                    
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
        Department::find($id)->delete();
                    return response("done");
    }

    public function getRegional(Request $request) {
        $regionals = \App\Regional::where('state_id',$request->sid)->get();
        $options = '<option selected="selected" hidden="hidden" disabled="disabled">إختر المحلية</option>';
        foreach ($regionals as $reg) {
            $options .= '<option value="'.$reg->regional_id.'">'.$reg->name.'</option>';
        }

        return $options;
    }
}
