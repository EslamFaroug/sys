@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.teachers")}} - {{trans('strings.contact information')}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center"> {{trans('strings.contact information')}} - {{trans('teacher.teachers')}}
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
                    <th>{{trans('strings.tr_email')}}</th>
                    <th>{{trans('strings.tr_mobile')}}</th>
                    <th>{{trans('strings.tr_countery')}}</th>
                    <th>{{trans('strings.tr_university')}}</th>
                    <th>{{trans('strings.tr_college')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contacts as $contact)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>@if($contact->teacher_ar_name) {{$contact->teacher_ar_name}} @else {{$contact->teachers->ar_name}} @endif</td>
                        <td>{{$contact->email}}</td>
                        <td>{{$contact->mobile_no}}</td>
                        <td>@if($contact->countery) {{$contact->countery}} @else {{$contact->countreis->name}} @endif</td>

                        <td>@if($contact->university)  {{$contact->university}} @else @if($contact->university_id) {{$contact->universities->name}} @endif @endif</td>
                        <td>@if($contact->college)  {{$contact->college}} @else @if($contact->college_id) {{$contact->colleges->name}} @endif @endif</td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
