<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Countery;
use \App\Teacher;
use \App\Special;
use \App\Train;
use \App\User;
use \App\Auth;
class TrainController extends Controller
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

            $trains        = Train::all();
            $teachers      = Teacher::all();
            $specials      = Special::all();
            $countreis     = Countery::all();
                return view('training.index', compact('trains','teachers','specials','countreis'));
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

        $tr_name = $request->teacher_id;
        $t_title = $request->title;
        $donor = $request->institute;
        $str_date = $request->st_date;
        $finl_date = $request->end_date;
        $tr_country = $request->countery_id;
        $tr_specialize = $request->special_id;

        //$file              = $request->file('path')->storeAS('training',time());

        $training = new Train();

        $training->teacher_id = $tr_name;
        $training->title = $t_title;
        $training->institute = $donor;
        $training->st_date = $str_date;
        $training->end_date = $finl_date;
        $training->countery_id = $tr_country;
        $training->special_id = $tr_specialize;
        // $training->path          = $file;
        if (request()->hasFile('image')) {
            $training->path = upload_image($request, '/storage/training', date("h_i_sa"), "", "");
        }
        if ($training->save()){

            return back()->with('success', 'data Saved Successfly');
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
        $train        = Train::find($id);
        return view('training.view', compact('train'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $trains        = Train::find($id);
        $teachers      = Teacher::all();
        $specials      = Special::all();
        $countreis     = Countery::all();
        return view('training.edit', compact('trains','teachers','specials','countreis'));
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

      //  $file_train              = $request->file('path')->store('/','training');

        $training                = Train::find($id);
        $training->teacher_id    = $request->teacher_id;
        $training->title         = $request->title;;
        $training->institute     = $request->institute;
        $training->st_date       = $request->st_date;
        $training->end_date      = $request->end_date;
        $training->countery_id   = $request->countery_id;
        $training->special_id    = $request->special_id;
       // $training->path          = $file_train;
        if (request()->hasFile('image')) {
            $training->path = upload_image($request, '/storage/training', date("h_i_sa"), $training->path , "");
        }
        if($training->save()){
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
        Train::find($id)->delete();
        return response("done");
    }
}
