<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function changeLanguage() {
    	$locale = \App::getLocale();

    	if(\Session::has('lang'))
    		$locale = \Session::get('lang');
    	
    	if($locale == 'ar') {
    		\Session::put('lang','en');
    	}elseif($locale == 'en') {
    		\Session::put('lang','ar');
    	}
    	return back();
    }
}
