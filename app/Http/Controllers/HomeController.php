<?php

namespace App\Http\Controllers;

use App\Genaral_Statistics;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $st=new GenaralStatisticsController();
          $genaral_Statistics=$st->all();

        return view('home',compact('genaral_Statistics'));
    }
}
