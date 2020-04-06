@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.teachers")}} - {{trans('strings.Qualifications & certificates')}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center"> {{trans('strings.Qualifications & certificates')}} - {{trans('teacher.teachers')}}
                @if($request->university_id) - {{\App\University::find($request->university_id)->name}} @endif
                @if($request->college_id) - {{\App\College::find($request->college_id)->name}} @endif
                @if($request->depart_id) - {{\App\Department::find($request->depart_id)->name}} @endif
                @if($request->special_id) - {{\App\Special::find($request->special_id)->name}} @endif
                @if($request->degree_id) - {{\App\Degree::find($request->degree_id)->name}} @endif
                @if($request->value) - {{$request->value}} @endif
            </h4>
        </div>
        <div class="panel-body">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{trans('strings.ID')}}</th>
                    <th>{{trans('strings.tr_name')}}</th>
                    <th>{{trans('teacher.tr_degree')}}</th>
                    <th>{{trans('strings.sert_name')}}</th>
                    <th>{{trans('strings.tr_university')}}</th>
                    <th>{{trans('strings.tr_college')}}</th>
                    <th>{{trans('strings.tr_specialization')}}</th>
                    <th>{{trans('strings.tr_countery')}}</th>
                    <th>{{trans('strings.study_type')}}</th>
                    <th>{{trans('strings.sert_date')}}</th>
                    <th>{{trans('strings.sert_grad')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($certificates as $certificate)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>@if($certificate->teacher_ar_name) {{$certificate->teacher_ar_name}} @else {{$certificate->teachers->ar_name}}  @endif</td>
                        <td>@if($certificate->degree)  {{$certificate->degree}} @else @if($certificate->degree_id) {{$certificate->degrees->name}} @endif @endif</td>
                        <td>{{$certificate->cert_name}}</td>
                        <td>@if($certificate->university)  {{$certificate->university}} @else @if($certificate->special_id) {{$certificate->specials->departments->colleges->universities->name}} @endif @endif</td>
                        <td>@if($certificate->college)  {{$certificate->college}} @else @if($certificate->special_id) {{$certificate->specials->departments->colleges->name}} @endif @endif</td>
                        <td>@if($certificate->university)  {{$certificate->university}} @else @if($certificate->special_id) {{$certificate->specials->departments->colleges->universities->name}} @endif @endif</td>
                        <td>@if($certificate->countery)  {{$certificate->countery}} @else @if($certificate->countery_id) {{$certificate->countreis->name}} @endif @endif</td>

                        <td>@if($certificate->study)  {{$certificate->study}} @else @if($certificate->study_id) {{$certificate->studes->name}} @endif @endif</td>
                        <td>{{$certificate->cert_date}}</td>
                        <td>{{$certificate->sert_grade}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
