<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use \App\User;
use \App\Role;
class MainPageController extends Controller
{

    public function index(){
    	return view('layouts.master');
    }

    public function admin()
    {
    	return view('layouts.admin');
    }

     public function orginal()
    {
        return view('layouts.Orginal_master');
    }
    public function profile1()
    {
        return view('layouts.profile1');
    }
    public function addRole(Request $request)
    {

    	$user = User::where('email', $request['email'])->first();
    	$user->roles()->detach();

    	if($request['role_admin']){
    	$user->roles()->attach(Role::where('name', 'Admin')->first());
    	}

    	if($request['role_teacher']){
    	$user->roles()->attach(Role::where('name', 'Teacher')->first());
    	}

    	if($request['role_user']){
    	$user->roles()->attach(Role::where('name', 'User')->first());
    	}

    	redirect()->back();

    }


     public function accessDenied()
    {
    	return view('layouts.access-denied');
    }

     public function teacher()
    {
    	return view('teachers.teacher');
    }
}
