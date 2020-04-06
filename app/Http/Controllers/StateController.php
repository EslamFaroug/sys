<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Countery;
use \App\State;
use \App\User;
use \App\Auth;

class StateController extends Controller
{
	     public function index($id=null)
	    {
	      	 if ($id == null)
	      	{
	       	     	$states = State::all();
	    			$countreis = Countery::all();
	    	    	return view('states.index',compact('states','countreis'));
	  		}
	    }
	    /*public function create()
   	   {
			        $name = $request -> name;
			        $count = $request -> countery_id;

			        $state = new Stste();

			        $state -> name = $name;
			        $state -> key = $countery_id;

			        $state -> save();

			        return response('done');

        }
*/
	    public function store(Request $request)

	    {
			    	$st_name   = $request->name;
			    	$countreis  = $request->countery_id;

			    	$state  = new State();

			    	$state->name        = $st_name;
			    	$state->countery_id = $countreis;

			    	$state->save();

			    	return response('done');
	    }

	    public function edit($id)
	    {
			        $states = State::find($id);
			        $countreis = Countery::all();
			        return view('states.edit',compact('states','countreis'));
	    }

	    public function update(Request $request, $id)
	    {
			        $states = State::find($id);
			        $states -> name = $request->name;
			        $states->countery_id = $request->countery_id;

			        $states->save();

			        return response('done');

	    }

	    public function destroy($id)
	    {
			        State::find($id)->delete();
			        return response("done");
	    }




    public function getRegional(Request $request) {
        $regionals = \App\Regional::where('state_id',$request->sid)->get();
        $options = '<option selected="selected" hidden="hidden" value="">إختر المحلية</option>';
        foreach ($regionals as $reg) {
            $options .= '<option value="'.$reg->regional_id.'">'.$reg->name.'</option>';
        }

        return $options;
    }

}
