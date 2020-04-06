<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \App\Certificate;
use \App\Teacher;
use \App\Degree;
use \App\Countery;
use \App\Study_type;
use \App\University;
use \App\College;
use \App\Department;
use \App\Special;
use \App\User;
use \App\Auth;
use Illuminate\Container;

class CertificateController extends Controller
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
            //die( Storage::disk("local")->exists('certificats/1572096727'));
            $certificates  = Certificate::all();
            $teachers      = Teacher::all();
            $degrees       = Degree::all();
            $countreis     = Countery::all();
            $universities  = University::all();
            $colleges      = College::all();
            $departments   = Department::all();
            $specials      = Special::all();
            $studes        = Study_type::all();
            //die($certificates);

            return view('certificates.index', compact('certificates', 'teachers', 'degrees', 'studes', 'countreis','universities', 'colleges','departments','specials'));
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
        // $this-> validate($request,[
        //     'cert_image'=>'required'
        // ]);

        $tr_name        = $request->teacher_id;
        $tr_degree      = $request->degree_id;
        $tr_cert        = $request->cert_name;
        $tr_specialize  = $request->special_id;
        $tr_country     = $request->countery_id;
        $cert_study     = $request->study_id;
        $cert_date      = $request->cert_date;
        $tr_grade       = $request->sert_grade;

     //   $file              = $request->file('cert_image')->storeAS('certificats',time());

        $certificat                = new Certificate();

        $certificat->teacher_id    = $tr_name;
        $certificat->degree_id     = $tr_degree;
        $certificat->cert_name     = $tr_cert;
        $certificat->university_id=$request->university_id;
        $certificat->college_id=$request->college_id;
        $certificat->depart_id=$request->depart_id;
        $certificat->special_id    = $tr_specialize;
        $certificat->countery_id   = $tr_country;
        $certificat->study_id      = $cert_study;
        $certificat->cert_date     = $cert_date;
        $certificat->sert_grade    = $tr_grade;
        if (request()->hasFile('image')) {
            $certificat->cert_image  = upload_image($request,'/storage/certificats',date("h_i_sa"),"","");
        }
        //$certificat->cert_image    =  $file;

        $certificat->save();

        return back()->with('success','data Saved Successfly');

        // $request->cert_image->move(public_path('img/Teachers'), $img_name);
        //             return redirect() -> route('cert');
    }


                    // $file = $request->file('cert_image');
                    // $imagename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                    // $request->file('cert_image')->move("img/Teachers", $imagename);
                    // $certificat->cert_image       = $imagename;

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $certificate  = Certificate::find($id);
        return view('certificates.view', compact('certificate'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $certificates  = Certificate::find($id);
            $teachers      = Teacher::all();
            $degrees       = Degree::all();
            $countreis     = Countery::all();
            $universities  = University::all();
            $colleges      = College::all();
            $departments   = Department::all();
            $specials      = Special::all();
            $studes        = Study_type::all();

                return view('certificates.edit', compact('certificates', 'teachers', 'degrees', 'studes', 'countreis','universities', 'colleges','departments','specials'));
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

            // $img_name = $request->file('cert_image')->store('/','teachers');


        $certificat             = Certificate::find($id);
        $certificat->teacher_id    = $request->teacher_id;
        $certificat->degree_id     = $request->degree_id;
        $certificat->cert_name     = $request->cert_name;
        $certificat->university_id=$request->university_id;
        $certificat->college_id=$request->college_id;
        $certificat->depart_id=$request->depart_id;
        $certificat->special_id    = $request->special_id;
        $certificat->countery_id   = $request->countery_id;
        $certificat->study_id      = $request->study_id;
        $certificat->cert_date     = $request->cert_date;
        $certificat->sert_grade    = $request->sert_grade;
        if (request()->hasFile('image')) {
            $certificat->cert_image  = upload_image($request,'/storage/certificats',date("h_i_sa"),$certificat->cert_image,"");
        }
        //$certificat->cert_image    = $request->img_name;

        if($certificat->save()){
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
        Certificate::find($id)->delete();
         return response("done");

        // if($certificat->hasFile('cert_image')){
        //     Storage::delete('public/img/Teachers/certificats'.$certificat->cert_image);
        // }

    }
}
