<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
    	$this->shareData();
    }

    public function shareData() {
    	\View::share('genders', [
    		1 => trans('teacher.male'),
    		2 => trans('teacher.female')
    	]);
    	\View::share('status', [
    		1 => trans('teacher.Single'),
    		2 => trans('teacher.Married'),
    		3 => trans('teacher.Divorced'),
    		4 => trans('teacher.widow')
    	]);
    }
}
