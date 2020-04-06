<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Qualification;
use \App\User;
use \App\Auth;

class QualificatController extends Controller
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

            $qualifications = Qualification::all();
            return view('qualifications.index',compact('qualifications'));

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
        $qual_name         = $request->name;

        $qualificat        = new Qualification();

        $qualificat->name  = $qual_name ;

        $qualificat-> save();

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
        $qualifications = Qualification::find($id);
        
        return view('qualifications.edit',compact('qualifications'));
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
        $qualificat        = Qualification::find($id);
        $qualificat ->name = $request->name;

        $qualificat->         save();
        
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
        Qualification::find($id)->delete();
        return response("done");
    }
}
