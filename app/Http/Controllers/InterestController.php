<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Teacher;
use \App\Interest;
use \App\Auth;
use \App\User;
class InterestController extends Controller
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
            $teachers     = Teacher::all();
            $interests    = Interest::all();
                return view('interests.index', compact('teachers','interests'));
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

        $this-> validate($request,[
            'title'=>'required'
        ]);
        

        $tr_name    = $request->teacher_id;
        $int_title  = $request->title;
        $int_decrip = $request->descrip;

        $interest   = new Interest();
        $interest->teacher_id = $tr_name;
        $interest->title      = $int_title;
        $interest->descrip    = $int_decrip;

        $interest->save();
            return back()->with('Success','تم حفظ البيانات بنجاح');
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
        
            
            $interests    = Interest::find($id);
            $teachers     = Teacher::all();
                return view('interests.edit', compact('teachers','interests'));
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
                $interest                = Interest::find($id);

                $interest ->teacher_id   = $request->teacher_id;
                $interest ->title        = $request->title;
                $interest ->descrip      = $request->descrip;


                $interest-> save();
                    
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
        Interest::find($id)->delete();
            return response("done");
    }
}
