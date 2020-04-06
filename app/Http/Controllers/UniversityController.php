<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Countery;
use \App\University;
use \App\Type;
use \App\User;
use \App\Auth;

class UniversityController extends Controller

{
    public function index($id = null)

    {

    	if ($id == null)

            {
                $countreis = Countery::all();
                $types = Type::all();
                $universities = University::all();
                return view('universities.index',compact('universities','types','countreis'));
            }

    }


    public function store( Request $request)

    {
    	        $un_name    = $request->name;
    	        $types      = $request->type_id;
			    $countreis  = $request->countery_id;

			    $unive  = new University();

			    $unive->name        = $un_name;
			    $unive->type_id     = $types;
			    $unive->countery_id = $countreis;

			    $unive->save();

			    return response('done');


    }


	    public function edit($id)

	    {
			        $universities = University::find($id);
			        $types=Type::all();
			        $countreis = Countery::all();
			        return view('universities.edit',compact('universities','types','countreis'));
	    }



	    public function update(Request $request, $id)
	    {
			        $University = University::find($id);
			        $University -> name = $request->name;
			        $University->type_id = $request->type_id;
			        $University->countery_id = $request->countery_id;

			        $University->save();

			        return response('done');

	    }

	    public function destroy($id)
	    {
			        University::find($id)->delete();
			        return response("done");
	    }


    public function getColleges(Request $request) {
        $colleges = \App\College::where('university_id',$request->uid)->get();
        $options = '<optgroup  label="'.trans('strings.college-select-placeholder').'">
                  <option selected="selected" value="">'.trans('strings.colleges').'</option>';
        foreach ($colleges as $college) {
            $options .= '<option value="'.$college->college_id.'">'.$college->name.'</option>';
        }
        $options .= '</optgroup >';

        return $options;
    }


}
