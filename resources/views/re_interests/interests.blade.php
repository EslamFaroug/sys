@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.teachers")}} - {{trans('strings.Interests')}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center"> {{trans('strings.Interests')}} - {{trans('teacher.teachers')}}
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
                    <th>{{trans('strings.tr_sk_name')}}</th>
                    <th>{{trans('strings.interest-input-label')}}</th>
                    <th>{{trans('strings.descrip-input-int')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($interests as $interest)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>@if($interest->teacher_ar_name) {{$interest->teacher_ar_name}} @else {{$interest->teachers->ar_name}}  @endif</td>
                        <td>{{$interest -> title}}</td>
                        <td>{{$interest -> descrip}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection