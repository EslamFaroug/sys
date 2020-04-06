@php
    $lang = Session::get('lang');
    \App::setLocale($lang);
@endphp
@extends('layouts.report')
@if($lang == 'ar')
@section('title') {{trans('strings.Experiences and Jobs')}} - {{$teacher->ar_name}}
@endsection
@elseif($lang == 'en')
@section('title') {{trans('strings.Experiences and Jobs')}} -  {{$teacher->en_name}}
@endsection
@endif

@section("content")
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center">
        @if($lang =='ar')
            <div >
                <h5 > {{trans('strings.Experiences and Jobs')}} - {{trans('strings.tr_data')}}{{$teacher->ar_name}}</h5>
            </div>
        @elseif($lang == 'en')
            <div >
                <h5 > {{trans('strings.Experiences and Jobs')}} - {{trans('strings.tr_data')}}{{$teacher->en_name}}</h5>
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
        <div class="label label-primary" style="font-size: 12px;">{{trans('strings.exp_title')}}</div>
        <br/>
        <br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{trans('strings.ID')}}</th>
                <th>{{trans('strings.job')}}</th>
                <th>{{trans('strings.tr_exp_institute')}}</th>
                <th>{{trans('strings.tr_countery')}}</th>
                <th>{{trans('strings.work_type')}}</th>
                <th>{{trans('strings.st_date')}}</th>
                <th>{{trans('strings.end_date')}}</th>
                <th>{{trans('strings.work_decrip')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($teacher->experiences as $experienc)
                <tr>
                <tr>
                    <td>{{$loop -> index+1}}</td>

                    <td>
                        @if($experienc->degree_id)
                            {{$experienc->degrees->name}}
                        @elseif($experienc->mangejob_id)
                            {{$experienc->mangejobs->name}}
                        @elseif($experienc->exp_name)
                            {{$experienc->exp_name}}
                        @endif
                    </td>

                    <td>
                        @if($experienc->degree_id)
                            {{$experienc->universities->name}}
                        @elseif($experienc->mangejob_id)
                            {{$experienc->universities->name}}
                        @elseif($experienc->exp_name)
                            {{$experienc->institute}}
                        @endif
                    </td>
                    <td>{{$experienc->countreis->name}}</td>
                    <td>{{$experienc->work_types->name}}</td>
                    <td>{{$experienc->start_date}}</td>
                    <td>{{$experienc->end_date}}</td>

                    <td>{{$experienc->decrip}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
    @endsection
