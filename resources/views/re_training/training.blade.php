@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.Training and courses')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Training and courses')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center">
        @if($lang =='ar')
            <div >
                <h5 > {{trans('strings.Training and courses')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
            </div>
        @elseif($lang == 'en')
            <div >
                <h5 > {{trans('strings.Training and courses')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
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
        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.train_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead>
            <th>#</th>
            <th>{{trans('strings.title-input-label')}}</th>
            <th>{{trans('strings.institute-input-label')}}</th>
            <th>{{trans('strings.training place')}}</th>
            <th>{{trans('strings.track of training')}}</th>
            <th>{{trans('strings.from_date')}}</th>
            <th>{{trans('strings.final_date')}}</th>
            </thead>
            <tbody>
            @foreach($teacher->trains as $train)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$train -> title}}</td>
                    <td>{{$train -> institute}}</td>
                    <td>{{$train->countreis->name}}</td>
                    <td>{{$train->specials->name}}</td>
                    <td>{{$train -> st_date}}</td>
                    <td>{{$train -> end_date}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
    @endsection
