<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Mangejob;
use \App\User;
use \App\Auth;

class MangejobController extends Controller
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

            $mangejobs = Mangejob::all();
            return view('mangejobs.index',compact('mangejobs'));

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
        $mang_name     = $request->name;

        $mange         = new Mangejob();

        $mange->name   = $mang_name ;

        $mange-> save();

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
        $mange = Mangejob::find($id);
        
        return view('mangejobs.edit',compact('mange'));
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
        $mange = Mangejob::find($id);
        $mange -> name = $request->name;

        $mange->save();
        
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
        Mangejob::find($id)->delete();
        return response("done");
    }
}
