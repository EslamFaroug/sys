<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Paper;
use \App\Teacher;
use \App\User;
use \App\Auth;
use \App\Skill;
class PaperController extends Controller
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
            $papers    = Paper::all();
            $teachers  = Teacher::all();
            return view('papers.index', compact('papers','teachers'));
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


        $tr_name          = $request->teacher_id;
        $paper_title      = $request->title;
        $publish          = $request->publish_place;
        $date_paper       = $request->publis_date;
        $volume           = $request->volume_no;
        //$file             = $request->file('peper_file')->storeAS('papers',time());

        $pap                 = new Paper();
        $pap->teacher_id     = $tr_name;
        $pap->title          = $paper_title;
        $pap->publish_place  = $publish;
        $pap->publis_date    = $date_paper;
        $pap->volume_no      = $volume;
        //$pap->peper_file     = $file;
        if (request()->hasFile('file')) {
            $pap->peper_file = upload_file($request,'/storage/papers',date("h_i_sa"),"","");
        }


        if($pap->save()){
            return back()->with('success','data Saved Successfly');

        }
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $paper    = Paper::find($id);

        return view('papers.view', compact('paper'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $papers    = Paper::find($id);
        $teachers  = Teacher::all();

            return view('papers.edit', compact('papers','teachers'));
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
        //$p_file              = $request->file('peper_file')->store('/','papers');
        $pap                 = Paper::find($id);
        $pap->teacher_id     = $request->teacher_id;
        $pap->title          = $request->title;
        $pap->publish_place  = $request->publish_place;
        $pap->publis_date    = $request->publis_date;
        $pap->volume_no      = $request->volume_no;
        //$pap->peper_file     = $request->p_file;
        if (request()->hasFile('file')) {
            $pap->peper_file = upload_file($request,'/storage/papers',date("h_i_sa"),$pap->peper_file,"");
        }

        if($pap->save()){
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
       Paper::find($id)->delete();
        return response("done");
    }
}
