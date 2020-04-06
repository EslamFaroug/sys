<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Degree;
use App\Teacher;
use App\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificateReportController extends Controller
{
    public function index(){
        $universities  = University::all();
        $degrees=Degree::all();
        $certificates=Certificate::all();
        return view('re_certificates.index', compact(['certificates','universities','degrees']));


    }

    public function resultCertificate(Request $request)
    {

        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=Certificate::all();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")

                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->orWhere('certificates.sert_grade','like',$request->value.'%')
                ->orWhere('certificates.cert_date','like','%'.$request->value.'%')
                ->orWhere('certificates.cert_name','like',$request->value.'%')
                ->orWhere('teachers.ar_name','like','%'.$request->value.'%')
                ->orWhere('teachers.en_name','like','%'.$request->value.'%')
                ->orWhere('counteries.name','like',$request->value.'%')
                ->orWhere('universities.name','like',$request->value.'%')
                ->orWhere('colleges.name','like',$request->value.'%')
                ->orWhere('departments.name','like',$request->value.'%')
                ->orWhere('specials.name','like',$request->value.'%')
                ->orWhere('study_types.name','like',$request->value.'%')
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                 ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }

        $html= view('re_certificates.row',['certificates'=>$certificates])->render();
        return response(['status'=>true,'result'=>$html]);
    }

    public function printCertificate($id=null)
    {
        return view('re_certificates.certificate')
            ->with('teacher',Teacher::find(Certificate::find($id)->teacher_id));
    }

    public function viewCertificate($id=null)
    {
        return view('re_certificates.certificateView')
            ->with('teacher',Teacher::find(Certificate::find($id)->teacher_id));
    }


    public function printCertificates(Request $request)
    {
        if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=Certificate::all();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")

                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->orWhere('certificates.sert_grade','like',$request->value.'%')
                ->orWhere('certificates.cert_date','like','%'.$request->value.'%')
                ->orWhere('certificates.cert_name','like',$request->value.'%')
                ->orWhere('teachers.ar_name','like','%'.$request->value.'%')
                ->orWhere('teachers.en_name','like','%'.$request->value.'%')
                ->orWhere('counteries.name','like',$request->value.'%')
                ->orWhere('universities.name','like',$request->value.'%')
                ->orWhere('colleges.name','like',$request->value.'%')
                ->orWhere('departments.name','like',$request->value.'%')
                ->orWhere('specials.name','like',$request->value.'%')
                ->orWhere('study_types.name','like',$request->value.'%')
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->unionAll($first)
                ->get();
        }else if($request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $first=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.ar_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id);
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.en_name','like','%'.$request->value.'%')
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->unionAll($first)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->get();
        }else if(!$request->value and $request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and !$request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and $request->university_id and $request->college_id and $request->depart_id  and $request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('certificates.university_id','=',$request->university_id)
                ->Where('certificates.college_id','=',$request->college_id)
                ->Where('certificates.depart_id','=',$request->depart_id)
                ->Where('certificates.special_id','=',$request->special_id)
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }else if(!$request->value and !$request->university_id and !$request->college_id and !$request->depart_id  and !$request->special_id   and $request->degree_id ){
            $certificates=DB::table("certificates")
                ->join("counteries","certificates.countery_id","=","counteries.countery_id")
                ->join("teachers","teachers.teacher_id","=","certificates.teacher_id")
                ->join("specials","specials.special_id","=","certificates.special_id")
                ->join("departments","departments.depart_id","=","certificates.depart_id")
                ->join("colleges","colleges.college_id","=","certificates.college_id")
                ->join("universities","universities.university_id","=","certificates.university_id")
                ->join("study_types","study_types.study_id","=","certificates.study_id")
                ->select('certificates.*',
                    'teachers.en_name as teacher_en_name','teachers.ar_name as teacher_ar_name',
                    'counteries.name as countery', 'universities.name as university',
                    'colleges.name as college', 'departments.name as department',
                    'specials.name as special', 'study_types.name as study'
                )
                ->Where('teachers.degree_id','=',$request->degree_id)
                ->get();
        }
        return view('re_certificates.certificates',compact("certificates","request"));

    }

}
