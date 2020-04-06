<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Teacher;
use \App\Contact;
use \App\Countery;
use \App\State;
use \App\Regional;
use \App\Unit;
use \App\University;
use \App\College;
use \App\Department;
use \App\Special;
use \App\User;
use \App\Auth
;
class ContactController extends Controller
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
            $teachers      = Teacher::all();
            $contacts      = Contact::all();
            $countreis     = Countery::all();
            $states        = State::all();
            $regionals     = Regional::all();
            $units         = Unit::all();
            $universities  = University::all();
            $colleges      = College::all();
            $departments   = Department::all();
            $specials      = Special::all();

        return view('tr_contact.index', compact('teachers', 'contacts',
                    'countreis','states','regionals', 'units',
                    'universities', 'colleges','departments','specials'));
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

        $this-> validate($request,[
            'email'=>'required'
        ]);
                    $tr_name       = $request->teacher_id;
                    $tr_email      = $request->email;
                    $tr_mobile     = $request->mobile_no;
                    $tr_tel        = $request->tel_no;
                    $tr_home_no    = $request->home_no;
                    $tr_websute    = $request->tr_web;
                    $tr_university = $request->university_id;
                    $tr_college    = $request->college_id;
                    $tr_department = $request->depart_id;
                    $tr_specialize = $request->special_id;
                    $tr_country    = $request->countery_id;
                    $tr_state      = $request->state_id;
                    $tr_regional   = $request->regional_id;
                    $tr_unit       = $request->unit_id;

                    $contact       = new Contact();

                    $contact->teacher_id    = $tr_name;
                    $contact->email         = $tr_email;
                    $contact->mobile_no     = $tr_mobile;
                    $contact->tel_no        = $tr_tel;
                    $contact->home_no       = $tr_home_no;
                    $contact->tr_web        = $tr_websute;
                    $contact->university_id = $tr_university;
                    $contact->college_id    = $tr_college;
                    $contact->depart_id     = $tr_department;
                    $contact->special_id    = $tr_specialize;
                    $contact->countery_id   = $tr_country;
                    $contact->state_id      = $tr_state;
                    $contact->regional_id   = $tr_regional;
                    $contact->unit_id       = $tr_unit;

                    $contact->save();

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
            $teachers      = Teacher::all();
            $contacts      = Contact::find($id);
            $countreis     = Countery::all();
            $states        = State::all();
            $regionals     = Regional::all();
            $units         = Unit::all();
            $universities  = University::all();
            $colleges      = College::all();
            $departments   = Department::all();
            $specials      = Special::all();

            return view('tr_contact.edit', compact('teachers', 'contacts',
                    'countreis','states','regionals', 'units',
                    'universities', 'colleges','departments','specials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
                $contact                  = Contact::find($request->contact_id);
                $contact ->teacher_id     = $request->teacher_id;
                $contact ->email          = $request->email;
                $contact->mobile_no       = $request->mobile_no;
                $contact->tel_no          = $request->tel_no;
                $contact->home_no         = $request->home_no;
                $contact->tr_web          = $request->tr_web;
                $contact->university_id   = $request->university_id;
                $contact->college_id      = $request->college_id;
                $contact->depart_id       = $request->depart_id;
                $contact->special_id      = $request->special_id;
                $contact->countery_id     = $request->countery_id;
                $contact->state_id        = $request->state_id;
                $contact->regional_id     = $request->regional_id;
                $contact->unit_id         = $request->unit_id;


                $contact-> save();

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
        Contact::find($id)->delete();
        return response("done");
    }
}
