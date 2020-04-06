<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function roleChange(Request $request)
    {
        if($request->type=="role_admin"){
            if($request->role==0){
              $re=  DB::table("user_role")->insert([
                    'user_id' => $request->id,
                    "role_id" => "1",
                ]);
            }else if($request->role==1){
                $re= DB::table("user_role")->where('user_id',$request->id)->where('role_id',"=","1")->delete();
            }

        }else if($request->type=="role_teacher"){
            if($request->role==0){
                $re=     DB::table("user_role")->insert([
                    'user_id' => $request->id,
                    "role_id" => "2",
                ]);
            }else if($request->role==1){
                $re=  DB::table("user_role")->where('user_id',$request->id)->where('role_id',"=","2")->delete();
            }
        }else if($request->type=="role_user"){
            if($request->role==0){
                $re=      DB::table("user_role")->insert([
                    'user_id' => $request->id,
                    "role_id" => "3",
                ]);
            }else if($request->role==1){
                $re=    DB::table("user_role")->where('user_id',$request->id)->where('role_id',"=","3")->delete();
            }
        }

        if($re){
            return response("true");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
