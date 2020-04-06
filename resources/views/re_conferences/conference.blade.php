@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.Conferences and meetings')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Conferences and meetings')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center">
            @if($lang =='ar')
                <div >
                    <h5 > {{trans('strings.Conferences and meetings')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
                </div>
            @elseif($lang == 'en')
                <div >
                    <h5 > {{trans('strings.Conferences and meetings')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
                </div>
            @endif


        </div>

        <div class="panel-body">
            <div class="label label-primary" style="font-size: 12px;">{{trans('strings.Basic information')}}</div>
            <br/>
            <br/>

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th style="width:150px;">{{trans('teacher.AR_Name')}}</th><td>{{$teacher->ar_name}}</td>
                </tr><tr>
                    <th>{{trans('teacher.en_name')}}</th><td>{{$teacher->en_name}}</td>
                </tr>

                </thead>
            </table>

            <div class="label label-primary" style="font-size: 12px;">{{trans('strings.re_conf_title')}}</div>
            <br/>
            <br/>
            <table class="table table-bordered">

                <thead>
                <th>#</th>
                <th>{{trans('strings.conf_nane')}}</th>
                <th>{{trans('strings.St_country')}}</th>
                <th>{{trans('strings.re_state')}}</th>
                <th>{{trans('strings.conf_date')}}</th>
                <th>{{trans('strings.participant_type')}}</th>
                </thead>
                <tbody>
                @if($teacher->conferences->count())

                    @foreach($teacher->conferences as $conf)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$conf->name}}</td>
                            <td>{{$conf->countreis->name}}</td>
                            <td>{{$conf->states->name}}</td>
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
                @endif

                </tbody>
            </table>

        </div>
    </div>
@endsection
