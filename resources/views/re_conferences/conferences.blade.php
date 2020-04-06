@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@section('title'){{trans('strings.print')}} {{trans("strings.Conferences and meetings")}}
@endsection


@section("content")

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="" style="text-align: center">  {{trans('strings.Conferences and meetings')}} - {{trans('teacher.teachers')}}
                @if($request->country_id) - {{\App\Countery::find($request->country_id)->name}} @endif
                @if($request->university_id) - {{\App\University::find($request->university_id)->name}} @endif
                @if($request->college_id) - {{\App\College::find($request->college_id)->name}} @endif
                @if($request->depart_id) - {{\App\Department::find($request->depart_id)->name}} @endif
                @if($request->special_id) - {{\App\Special::find($request->special_id)->name}} @endif
                @if($request->degreel_id) - {{\App\Degree::find($request->degreel_id)->name}} @endif
                @if($request->title) - {{$request->title}} @endif
                @if($request->value) - {{$request->value}} @endif
                @if($request->date) - {{$request->date}} @endif
            </h4>
        </div>
        <div class="panel-body">
            <table class="table datatable">
                <thead>
                <tr>
                    <th>{{trans('strings.ID')}}</th>
                    <th>{{trans('strings.tr_sk_name')}}</th>
                    <th>{{trans('strings.conf_nane')}}</th>
                    <th>{{trans('strings.St_country')}}</th>
                    <th>{{trans('strings.conf_date')}}</th>
                    <th>{{trans('strings.participant_type')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($conferences as $conf)
                    <tr>
                        <td>{{$loop -> index+1}}</td>
                        <td>{{$conf -> ar_name}}</td>
                        <td>{{$conf->name}}</td>
                        <td>{{$conf->countery}}</td>

                        <td>{{$conf->conf_date}}</td>
                        <td>
                            @if($conf->participant == 1)
                                {{trans('strings.member')}}
                            @elseif($conf->participant == 2)
                                {{trans('strings.participants')}}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
