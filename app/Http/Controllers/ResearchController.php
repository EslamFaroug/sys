<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Research;
use \App\Teacher;
use \App\Degree;
use \App\Auth;
use \App\User;
class ResearchController extends Controller
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
            $researches = Research::all();
            $teachers   = Teacher::all();
            $degrees    = Degree::all();
            return view('researches.index', compact('researches','teachers','degrees'));
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
        $re_title            = $request->title;
        $tr_degree           = $request->degree_id;
        $publish             = $request->publish_date;
        $prp                 = $request->publish_place;
        $sup_id              = $request->sup_id;
        $other_supervisor    = $request->other_supervisor;

       // $file              = $request->file('research_file')->storeAS('researches',time());
        $research            = new Research();


        $research->teacher_id        = $tr_name;
        $research->title             =  $re_title;
        $research->degree_id         = $tr_degree;
        $research->publish_date      = $publish;
        $research->publish_place     = $prp;
        //$research->research_file     = $file;
        if (request()->hasFile('file')) {
            $research->research_file = upload_file($request,'/storage/researches',date("h_i_sa"),"","");
        }
        if($other_supervisor == 0)
        {
            $research->supervisor_id  = $sup_id;
        }
        elseif($other_supervisor == 1)
        {
            $research->other_supervisor = $sup_id;
        }




        // $degree_id            = $request->degree_id;
        // $sup_id            = $request->sup_id;
        // $other_supervisor  = $request->other_supervisor;
        // $rpdate            = $request->publish_date;
        // $prp               = $request->publish_place;

        // $re_file = $request->file('research_file')->store('/','researches');

        // $research          = new Research();

        // $research->teacher_id = $teacher_id;
        // $research->title  = $title;

        // $research->degree_id = $degree_id;
        // if($other_supervisor == 0) {
        //     $research->supervisor_id  = $sup_id;
        // }elseif($other_supervisor == 1) {
        //     $research->other_supervisor = $sup_id;
        // }
        // $research->publish_date = $rpdate;

        // $research->research_file    = $re_file;

        // $file = $request->file('research_file');
        // $input['research_file'] = time().'.'.$file->getClientOriginalExtension();
        // $destinationPath = public_path('/img/Teachers/researches');
        // $file->move($destinationPath, $input['research_file']);

        // $destinationPath .= $input['research_file'];
        // $research->research_file_path=$destinationPath;

        $research->save();

        return back()->with('success','data Saved Successfly');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $research    = Research::find($id);
        return view('researches.view', compact('research'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $research    = Research::find($id);
        $teachers   = Teacher::all();
        $degrees    = Degree::all();
        return view('researches.edit', compact('research','teachers','degrees'));

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
        $tr_name             = $request->teacher_id;
        $re_title            = $request->title;
        $tr_degree           = $request->degree_id;
        $publish             = $request->publish_date;
        $prp                 = $request->publish_place;
        $sup_id              = $request->sup_id;
        $other_supervisor    = $request->other_supervisor;

        // $file              = $request->file('research_file')->storeAS('researches',time());
        $research            =  Research::find($id);;


        $research->teacher_id        = $tr_name;
        $research->title             =  $re_title;
        $research->degree_id         = $tr_degree;
        $research->publish_date      = $publish;
        $research->publish_place     = $prp;
        //$research->research_file     = $file;
        if (request()->hasFile('file')) {
            $research->research_file = upload_file($request,'/storage/researches',date("h_i_sa"),$research->research_file,"");
        }
        if($other_supervisor == 0)
        {
            $research->supervisor_id  = $sup_id;
        }
        elseif($other_supervisor == 1)
        {
            $research->other_supervisor = $sup_id;
        }

        if($research->save()){
            return response("done");

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Research::find($id)->delete();
        return response("dond");
    }
}
