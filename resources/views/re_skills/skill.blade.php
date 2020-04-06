@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.Skills and activities')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Skills and activities')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center">
        @if($lang =='ar')
            <div >
                <h5 > {{trans('strings.Skills and activities')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
            </div>
        @elseif($lang == 'en')
            <div >
                <h5 > {{trans('strings.Skills and activities')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
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
        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.skill_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>{{trans('strings.skill_name')}}</th>
                <th>{{trans('strings.skill_desc')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($teacher->skills as $skill)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$skill -> name}}</td>
                    <td>{{$skill -> decription}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endsection
